<?php
namespace Controller;

use Core\DB;
use Exception;
use Phar;
use PharData;
use ZipArchive;

class FestivalController {
    /**
     * Page
     */
    function festivalPage(){
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1;

        view("festival", [
            "festivals" => pager($page, DB::fetchAll("SELECT *, CONCAT(LPAD(sn, 3, 0), '_', no) dirname FROM festivals ORDER BY sn DESC"))
        ]);
    }

    function detailPage(){
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $festival = DB::fetch("SELECT *, CONCAT(LPAD(sn, 3, 0), '_', no) dirname FROM festivals WHERE sn = ?", [$id]);
        if(!$festival) back("축제 정보가 존재하지 않습니다.");

        $reviews = DB::fetchAll("SELECT * FROM festival_reviews WHERE fid = ?", [$id]);

        view("festival-detail", compact("festival", "reviews"));
    }

    /**
     * Action
     */
    function downloadImageTar(){
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $festival = DB::fetch("SELECT CONCAT(LPAD(sn, 3, 0), '_', no) dirname, images FROM festivals WHERE sn = ?", [$id]);
        $images = filter_realfile(json_decode($festival->images), FIMAGE.DS.$festival->dirname);

        if(count($images) == 0) back("업로드한 사진이 없는 축제입니다.");

        try {
            $filename = "festival_images_". time().".tar";
            $filepath = ARCHIVE.DS.$filename;

            $phar = new PharData($filepath);
            foreach($images as $imageName){
                $imagePath = FIMAGE.DS.$festival->dirname.DS.$imageName;
                if(is_file($imagePath)){
                    $phar->addFile($imagePath, $imageName);
                }
            }
            $phar->compress(Phar::GZ);

            header('Content-Type: application/octet-stream');
            header("Content-Disposition: attachement;filename=".$filename);
            ob_clean();
            readfile($filepath);
            unlink($filepath);

        } catch (\Exception $e){
            back("이미지를 압축하는 도중 문제가 발생했습니다.");
        }
    }

    function downloadImageZip(){
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $festival = DB::fetch("SELECT CONCAT(LPAD(sn, 3, 0), '_', no) dirname, images FROM festivals WHERE sn = ?", [$id]);
        $images = filter_realfile(json_decode($festival->images), FIMAGE.DS.$festival->dirname);

        if(count($images) == 0) back("업로드한 사진이 없는 축제입니다.");
        
        try {
            $filename = "festival_images_". time().".zip";
            $filepath = ARCHIVE.DS.$filename;

            $zip = new ZipArchive();
            $result = $zip->open($filepath, ZipArchive::OVERWRITE | ZipArchive::CREATE);
            if($result === TRUE){
                foreach($images as $imageName){
                    $imagePath = FIMAGE.DS.$festival->dirname.DS.$imageName;
                    if(is_file($imagePath)){
                        $zip->addFile($imagePath, $imageName);
                    }
                }
                $zip->close();
                header('Content-Type: application/octet-stream');
                header("Content-Disposition: attachement;filename=".$filename);
                ob_clean();
                readfile($filepath);
                unlink($filepath);
            } else {
                throw new Exception("압축 파일 생성 실패");
            }

        } catch (\Exception $e){
            back("이미지를 압축하는 도중 문제가 발생했습니다.");
        }
    }


    function writeFestival(){
        checkEmpty();
        extract($_POST);

        // 양식 확인
        if(!preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} ~ [0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/", $dt))
            back("올바른 축제 기간을 입력해 주세요. (ex 2020-01-01 ~ 2020-01-20)");


        // 이미지 파일명 저장 & 양식 확인
        $valid_extname = [".png", ".jpg", ".gif", ".jpeg"];
        $images = $_FILES['images'];
        
        $filenames = [];
        $tmpnames = [];
        for($i = 0; $i < count($images['name']); $i++){
            $name = ($i + 1) . "_" . $images['name'][$i];
            $tmpnames[] = $images['tmp_name'][$i];
            $extname = strtolower(extname($name));

            if(!$tmpnames[$i]) continue;
            if(array_search($extname, $valid_extname) === false){
                back("이미지는 png, jpg, gif 형식만 업로드하실 수 있습니다.");
            }

            $filenames[] = $name;
        }
        
        // 데이터 삽입
        $no = substr((string)time(), -5);
        DB::query("INSERT INTO festivals(no, nm, location, dt, images) VALUES (?, ?, ?, ?, ?)", [
            $no, $nm, $location, $dt, json_encode($filenames)
        ]);
        $sn = DB::lastInsertId();
        
        // 이미지 저장
        $dirname = FIMAGE . DS . str_pad($sn, 3, "0", STR_PAD_LEFT) . "_" . $no;
        if(!is_dir($dirname)){
            mkdir($dirname, 0777, true);
        }
        for($i = 0; $i < count($filenames); $i++){
            move_uploaded_file($tmpnames[$i], $dirname . DS. $filenames[$i]);
        }
        go("/festivals", "축제가 등록되었습니다.");
    }

    function editFestival(){
        $input = json_decode(file_get_contents("php://input"));
        $festival = DB::fetch("SELECT * FROM festivals WHERE sn = ?", [$input->id]);
        if(!$festival) json_response("축제 정보가 존재하지 않습니다.");

        // 기존 파일 삭제하기
        $dirname = FIMAGE.DS.str_pad($festival->sn, 3, "0", STR_PAD_LEFT)."_".$festival->no;
        $festival->images = json_decode($festival->images);
        foreach($festival->images as $imageName){
            if(array_search($imageName, $input->left_images) === false){
                $filePath = $dirname.DS.$imageName;
                unlink($filePath);
            }
        }
        
        // 새 파일 업로드하기
        $add_images = [];
        foreach($input->add_images as $idx => $imageBase64){
            $filebase = ($idx + 1)."_".time();
            $add_images[] = upload_base64($dirname, $imageBase64, $filebase);
        }
        
        // DB에 저장하기
        DB::query("UPDATE festivals SET nm = ?, dt = ?, location = ?, images = ? WHERE sn = ?", [
            $input->nm, $input->dt, $input->location, json_encode(array_merge($input->left_images, $add_images)), $input->id
        ]);

        json_response(["result" => true, "message" => "수정되었습니다."]);
        
    }

    function removeFestival(){
        $id = file_get_contents("php://input");
        $festival = DB::fetch("SELECT * FROM festivals WHERE sn = ?", [$id]);
        if(!$festival) json_response("축제 정보를 찾을 수 없습니다.");
        
        $dirname = FIMAGE . DS . str_pad($festival->sn, 3, "0", STR_PAD_LEFT) . "_" . $festival->no;
        $festival->images = json_decode($festival->images);
        foreach($festival->images as $imageName){
            unlink($dirname.DS.$imageName);
        }
        rmdir($dirname);

        DB::query("DELETE FROM festivals WHERE sn = ?", [$id]);
        json_response(["result" => true, "message" => "삭제되었습니다."]);
    }

    function writeReview(){
        checkEmpty();
        extract($_POST);
        
        $festival = DB::fetch("SELECT * FROM festivals WHERE sn = ?", [$fid]);
        if(!$festival) back("축제 정보를 찾을 수 없습니다.");

        DB::query("INSERT INTO festival_reviews(fid, name, comment, score) VALUES (?, ?, ?, ?)", [
            $fid, $name, $comment, $score
        ]);
        go("/festivals/details?id=$fid", "후기를 작성하였습니다.");
    }

    function removeReview(){
        $id = file_get_contents("php://input");
        $review = DB::fetch("SELECT * FROM festival_reviews WHERE id = ?", [$id]);
        if(!$review) json_response("후기 정보를 찾을 수 없습니다.");
        DB::query("DELETE FROM festival_reviews WHERE id = ?", [$id]);
        json_response(["message" => "후기를 삭제하였습니다.", "result" => true]);
    }
}