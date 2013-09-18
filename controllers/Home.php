<?php
function getLatestDoctors(){
	global $doctor;
	global $globalUtil;
	$limit=20;
	$latestDocs=$doctor->getDoctor($globalUtil,"WHERE status='1' ORDER BY createDt DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestDocs);echo "<pre>";die();
	return $latestDocs;
	}
function getLatestHospitalFeatured(){
	global $hospital;
	global $globalUtil;
	$limit=20;
	$latestHospfeatured=$hospital->getHospitalFeatured($globalUtil,"WHERE status='1' AND featured_value='1' ORDER BY createDt DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestHospfeatured);echo "<pre>";die();
	return $latestHospfeatured;
	}
function getLatestDoctorsFeatured(){
	global $doctor;
	global $globalUtil;
	$limit=20;
	$latestDocsfeatured=$doctor->getDoctorFeatured($globalUtil,"WHERE status='1' AND featured_value='1' ORDER BY createDt DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestDocsfeatured);echo "<pre>";die();
	return $latestDocsfeatured;
	}
function getLatestPathologyCenterFeatured(){
	global $pathology;
	global $globalUtil;
	$limit=20;
	$latestPathfeatured=$pathology->getPathologyFeatured($globalUtil,"WHERE status='1' AND featured_value='1' ORDER BY viewedcount DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestPathfeatured);echo "<pre>";die();
	return $latestPathfeatured;
	}
function getLatestHospitalMostViewed(){
	global $hospital;
	global $globalUtil;
	$limit=5;
	$latestHospviewed=$hospital->getHospitalMostViewed($globalUtil,"WHERE status='1'  ORDER BY viewedcount DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestHospfeatured);echo "<pre>";die();
	return $latestHospviewed;
	}
function getLatestDoctorsMostViewed(){
	global $doctor;
	global $globalUtil;
	$limit=5;
	$latestDocsviewed=$doctor->getLatestDoctorsMostViewed($globalUtil,"WHERE status='1'  ORDER BY viewedcount DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestDocsfeatured);echo "<pre>";die();
	return $latestDocsviewed;
	}
function getLatestPathologyCenterMostViewed(){
	global $pathology;
	global $globalUtil;
	$limit=5;
	$latestPathviewed=$pathology->getPathologyMostViewed($globalUtil,"WHERE status='1'  ORDER BY viewedcount DESC LIMIT 0,".$limit);
	//echo "<pre>";print_r($latestPathfeatured);echo "<pre>";die();
	return $latestPathviewed;
	}
function getlatestNews(){
	global $globalUtil;
	$news=new LatestNews;
	$newslist=$news->getLastestNews($globalUtil,"WHERE status='1'");
	//echo "<pre>";print_r($newslist);echo "<pre>";die();
	return $newslist;
	}
function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	arsort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}


?>