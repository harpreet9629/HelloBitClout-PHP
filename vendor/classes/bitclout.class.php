<?php

class Bitclout{
	protected $output = array();
	protected $apiURL = 'https://tijn.club/api/v0';

	public function __construct(){}

	public function getPostsByKey($key, $limit){
		$output = [];
	    $url = $this->apiURL.'/get-posts-for-public-key';

	    $data = array("LastPostHashHex" => "", "MediaRequired" => false, "NumToFetch" => $limit, "PublicKeyBase58Check" => $key, "ReaderPublicKeyBase58Check" => "", "Username" => "");

	    $postdata = json_encode($data);
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    $result = curl_exec($ch);
	    curl_close($ch);
	    $results = json_decode($result, true);
		foreach($results['Posts'] as $result){
			if(!empty($result['RecloutedPostEntryResponse'])){
			$rprofile = $this->getUserProfile($result['RecloutedPostEntryResponse']['PosterPublicKeyBase58Check']);
			$ReClout = array(
					'PostHashHex' => $result['RecloutedPostEntryResponse']['PostHashHex'],
					'PosterPublicKeyBase58Check' => $result['RecloutedPostEntryResponse']['PosterPublicKeyBase58Check'],
					'Body' => $result['RecloutedPostEntryResponse']['Body'], 
					'ImageURLs' => $result['RecloutedPostEntryResponse']['ImageURLs'], 
					'DiamondCount' => $result['RecloutedPostEntryResponse']['DiamondCount'], 
					'LikeCount' => $result['RecloutedPostEntryResponse']['LikeCount'], 
					'CommentCount' => $result['RecloutedPostEntryResponse']['CommentCount'], 
					'RecloutCount' => $result['RecloutedPostEntryResponse']['RecloutCount'], 
					'QuoteRecloutCount' => $result['QuoteRecloutCount'], 
					'TimestampNanos' => $result['RecloutedPostEntryResponse']['TimestampNanos'], 
					'Profile' => $rprofile,
				);
			}
			else{
				$ReClout = '';
			}
			$profile = $this->getUserProfile($result['PosterPublicKeyBase58Check']);
			$this->output[] = array(
				'PostHashHex' => $result['PostHashHex'],
				'PosterPublicKeyBase58Check' => $result['PosterPublicKeyBase58Check'],
				'Body' => $result['Body'], 
				'ImageURLs' => $result['ImageURLs'], 
				'DiamondCount' => $result['DiamondCount'], 
				'LikeCount' => $result['LikeCount'], 
				'CommentCount' => $result['CommentCount'], 
				'RecloutCount' => $result['RecloutCount'], 
				'QuoteRecloutCount' => $result['QuoteRecloutCount'], 
				'TimestampNanos' => $result['TimestampNanos'], 
				'Profile' => $profile,
				'ReClout' => $ReClout
			);
		}
	    return $this->output;
	}

	public function submitPost($key, $body){
		$url = $this->apiURL.'/submit-post';
		$data = array( 'UpdaterPublicKeyBase58Check' => $key, 'PostHashHexToModify' => "", 'ParentStakeID' => "", 'Title' => "", 'BodyObj' => array("Body" => $body), 'RecloutedPostHashHex' => "", 'Sub' => "", 'IsHidden' => false, 'MinFeeRateNanosPerKB' => 1000);
	    $postdata = json_encode($data);
	    $output = array();
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    $result = curl_exec($ch);
	    curl_close($ch);
	    $results = json_decode($result, true);
	    return $results;
	}

	public function submitTransaction($txn){
		$url = $this->apiURL.'/submit-transaction';
		$data = array( 'TransactionHex' => $txn);
	    $postdata = json_encode($data);
	    $output = array();
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    $result = curl_exec($ch);
	    curl_close($ch);
	    $results = json_decode($result, true);
	    return $results;
	}

	public function getUserProfile($key){
	    $url = $this->apiURL.'/get-single-profile';
	    $data = array("PublicKeyBase58Check" => $key);
	    $postdata = json_encode($data);
	    $output = array();
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	    $result = curl_exec($ch);
	    curl_close($ch);
	    $results = json_decode($result, true);
	    $output = array('Username' => $results['Profile']['Username'], 'IsVerified' => $results['Profile']['IsVerified']);
	    return $output;
	}

	public function number_format_short( $n, $precision = 1 ) {
	    if ($n < 900) {
	        $n_format = number_format($n, $precision);
	        $suffix = '';
	    } else if ($n < 900000) {
	        $n_format = number_format($n / 1000, $precision);
	        $suffix = 'K';
	    } else if ($n < 900000000) {
	        $n_format = number_format($n / 1000000, $precision);
	        $suffix = 'M';
	    } else if ($n < 900000000000) {
	        $n_format = number_format($n / 1000000000, $precision);
	        $suffix = 'B';
	    } else {
	        $n_format = number_format($n / 1000000000000, $precision);
	        $suffix = 'T';
	    }
	    return $n_format.$suffix;
	}
}

