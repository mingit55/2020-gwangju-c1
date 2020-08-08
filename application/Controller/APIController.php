<?php
namespace Controller;

use Core\DB;

class APIController {
    /**
     * 행사정보 불러오기
     */
    function getFestivals(){
        json_response(["festivals" => DB::fetchAll("SELECT * FROM xml_festivals")]);   
    }

    /**
     * XML 파일 DB에 업로드하기
     */
    function insertDatabaseXML(){
        $xmlFile = "/resources/xml/festivalList.xml";
        $filePath = ROOT. str_replace("/", DS, $xmlFile);
        DB::query("DELETE FROM xml_festivals");

        $xml = simplexml_load_file($filePath);
        foreach($xml->items[0] as $item){
            $sn = (string)$item->sn;
            $no = (string)$item->no;
            $nm = (string)$item->nm;
            $area = (string)$item->area;
            $location = (string)$item->location;
            $dt = (string)$item->dt;
            $cn = (string)$item->cn;
            $images = json_encode(((array)$item->images)["image"]);
            $data = [$sn, $no, $nm, $area, $location, $dt, $cn, $images];

            DB::query("INSERT INTO xml_festivals (sn, no, nm, area, location, dt, cn, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", $data);
            echo "\"{$nm}\" 업로드 완료<br>";
        }
    }
}