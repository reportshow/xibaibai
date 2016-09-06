<?
function getuserbyid($id){ 
   
	 $user = db_read('user',$id); 
	 return $user;
}

function getSiteinfo($siteid){
	$site = db_read('site', $siteid);
	if(count($site) > 1) return $site;
	
}
function addressByroomid($roomid){
     $room = db_read('rooms', trim($roomid)); 
	 $site = getSiteinfo($room['siteid']);
	 $address = $site['school'] . '/'.$site['building'] .'号楼/'. $room['room'] .'室';
	 return $address;
}

function getWorkerBybuilding($building){
	if(!$building) return;
	
	$filter  = "building='$building'";
	$room = db_read('rooms', $filter);
	if(count($room) > 1)
	{
		return $room['workerid'];
	}
}


function getworkerid($roomid){
	if(!$roomid) return;
	 
	$room = db_read('rooms', $roomid);
	 
	$site= db_read('site', $room['siteid']);
	
	if(count($site) > 1)
	{
		return $site['workerid'];
	}
} 

function getworkerinfo($workerid){
	$worker = db_read('worker', $workerid);
	return $worker;
}

function getQRlink($room){
	   	 $qrcodeurl = $room['qrcodeurl'];
	   	 $id = $room['uid'];
   	 if(!$qrcodeurl) {
   	     $tickets = wxQRcode(array($id));	
   	      
   	     if(count($tickets)){
   	       $qrcodeurl = $tickets[$id];
   	       $room['qrcodeurl'] = $qrcodeurl;
   	       db_write('rooms', $room);
   	     }else{
   	       // continue;
   	     }
   	 }
   	 return  wxTicketurl($qrcodeurl);

}