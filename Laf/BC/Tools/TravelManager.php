<?php
namespace BC\Tools;

class TravelManager{

	public static function weather($city_name){
		$data['data']['city_name']=$city_name;
		$ret=\BC\Tools\IOTool::HttpRequestWithParams('api','travelmanager',$data,'getWeather',4,10,'','post');
        if($ret['code'] == 100000)
        {
            return $ret['data'];
        }
	}

	public static function exChangeRate($scur,$tcur,$price=1){
		$data['data']['scur']=$scur;
		$data['data']['tcur']=$tcur;
		$data['data']['price']=$price;
		$ret=\BC\Tools\IOTool::HttpRequestWithParams('api','travelmanager',$data,'getExChangeRate',4,10,'','post');
        if($ret['code'] == 100000)
        {
            return $ret['data'];
        }
	}	

	public static function addManagerNote($params){
		$data['data']=$params;
		$ret=\BC\Tools\IOTool::HttpRequestWithParams('api','travelmanager',$data,'addManagerNote');
		// print_r($data);
		// dd($ret);
        if($ret['code'] == 100000)
        {
            return $ret['data'];
        }
	}
	public static function getManagerNote($manager_id){
		$data['data']['manager_id']=$manager_id;
		$ret=\BC\Tools\IOTool::HttpRequestWithParams('api','travelmanager',$data,'getManagerNote');
        if($ret['code'] == 100000)
        {
            return $ret['data'];
        }
	}
	public static function updateManagerNote($params){
		$data['data']=$params;
		$ret=\BC\Tools\IOTool::HttpRequestWithParams('api','travelmanager',$data,'updateManagerNote');
        if($ret['code'] == 100000)
        {
            return $ret['data'];
        }
	}
	public static function delManagerNote($note_id){
		$data['data']=$note_id;
		$ret=\BC\Tools\IOTool::HttpRequestWithParams('api','travelmanager',$data,'delManagerNote');
		// print_r($data);
        if($ret['code'] == 100000)
        {
            return $ret['data'];
        }
	}	
	public static function geliefofm($city_name){
		$ch = curl_init();
	   	$url = "http://admin.geliefofm.com/baicheng/api.aspx?key={$city_name}";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_HEADER, 0);
	   	$res = curl_exec($ch);
	   	$result = json_decode($res,true);
	   	if($result['status']==1){
	   		return $result['url'];
	   	}
	}				
	/**
    * 获取热门城市/国家 ： getHots
    */
    public static function getHots(){
        $req['data']='';
        $res=\BC\Tools\IOTool::HttpRequestWithParams('api','search',$req,'getHots',4,0,'','get');
        if($res['code']==10000){
        	$data=$res['data'];
        }else{
        	$data='';
        }
        return $data;
    } 
    /**
     * 获取频道列表 ： getChannels
     */
    public static function getChannels(){
    	$req['data']='';
        $res=\BC\Tools\IOTool::HttpRequestWithParams('api','search',$req,'getChannels',4,0,'','get');
        if($res['code']==10000){
        	$data=$res['data'];
        }else{
        	$data='';
        }
        return $data;
    }	
    /**
    * 获取热门目的地列表
    */	
    public static function getHotDestinationList(){
    	$hotdestination_req['data']='';
        $hotdestination=\BC\Tools\IOTool::HttpRequestWithParams('boss','net',$hotdestination_req,'GetIndexHotDestination',4,10,'','post');
        if($hotdestination['code']==100000){
        	$res=$hotdestination['data'];
        }else{
        	$res='';
        }
        return $res;
    }
}