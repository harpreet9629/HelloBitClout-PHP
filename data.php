<?php
require_once('vendor/autoload.php');
if(isset($_REQUEST['publicKey']) && !empty($_REQUEST['publicKey'])){
    $clout = new Bitclout();
    $result = $clout->getPostsByKey($_REQUEST['publicKey'], 10);
    $output['status'] = 100;
    $output['posts'] = '';
    $html = '';
    $html = '';
	foreach($result as $p):
		$html .= '<item>
	    	<div class="post-wrapper bg-white border my-3 rounded">
	    		<div class="post-inner d-flex flex-row p-3">
	    				<div class="userImage">
	    					<a href="https://bitclout.com/u/'.$p['Profile']['Username'].'"  style="background-image:url(https://bitclout.com/api/v0/get-single-profile-picture/'.$p ['PosterPublicKeyBase58Check'].')" targt="_blank"></a>
	    				</div>
	    				<div class="userInfo flex-fill">
	    					<a href="https://bitclout.com/u/'.$p['Profile']['Username'].'" targt="_blank">'.$p['Profile']['Username']. '</a>
	    				';
	    			if(!empty($p['Body'])) :
	    $html .= '  <div class="post-body mt-1 px-3">
	    				'.nl2br( convertAllTags($p['Body']) ).'
	    			</div>';
	    			endif;
	    			if(isset($p['ImageURLs']) && !empty($p['ImageURLs'])):
	    $html .= '  <div class="post-image px-3 mt-3">
	    				<img class="rounded" src="'.$p['ImageURLs'][0].'" alt=""/>
	    			</div>';
	    			endif;
	    if(!empty($p['ReClout']) && !empty($p['ReClout']['Profile']['Username'])){
	    	$html .= '<item class="sub">
		    	<div class="post-wrapper bg-white m-3 border rounded">
		    		<div class="post-inner  d-flex flex-row  p-3">
		    				<div class="userImage">
		    					<a href="https://bitclout.com/u/'.$p['ReClout']['Profile']['Username'].'"  style="background-image:url(https://bitclout.com/api/v0/get-single-profile-picture/'.$p['ReClout']['PosterPublicKeyBase58Check'].')" targt="_blank"></a>
		    				</div>
                            <div class="m-0 userInfo flex-fill">
                                <a href="https://bitclout.com/u/'.$p['ReClout']['Profile']['Username'].'" targt="_blank">'.$p['ReClout']['Profile']['Username'].'</a>
                            ';
                            if(!empty($p['ReClout']['Body'])) :
                $html .= '  <div class="post-body mt-1 px-3">
                                '.nl2br( convertAllTags($p['ReClout']['Body']) ).'
                            </div>';
                            endif;
                            if(isset($p['ReClout']['ImageURLs']) && !empty($p['ReClout']['ImageURLs'])):
                $html .= '  <div class="post-image px-3 mt-3">
                                <img class="rounded" src="'.$p['ReClout']['ImageURLs'][0].'" alt=""/>
                            </div>';
                            endif;
                            $commentIcon = ($p['ReClout']['CommentCount'] != 0) ? 'fa-comment' : 'fa-comment-o';
                            $RecloutCount = ($p['ReClout']['RecloutCount'] != 0) ? 'text-success' : '';
                            $LikeCount = ($p['ReClout']['LikeCount'] != 0) ? 'fa-heart text-danger' : 'fa-heart-o';
                            $DiamondCount = ($p['ReClout']['DiamondCount'] != 0) ? 'text-primary' : '';
                $html .= '  <div class="post-footer mt-3 px-3">
                                <div class="d-flex justify-content-around flex-row">
                                        <span class="comments"><i class="fa  '.$commentIcon.'" aria-hidden="true"></i> '.$p['ReClout']['CommentCount'].'</span>
                                        <span class="reclouts"><i class="fa fa-retweet '.$RecloutCount.'" aria-hidden="true"></i> '.$p['ReClout']['RecloutCount'].'</span>
                                        <span class="love"><i class="fa '.$LikeCount.'"  aria-hidden="true"></i> '.$p['ReClout']['LikeCount'].'</span>
                                        <span class="diamonds"><i class="fa fa-diamond '.$DiamondCount.'" aria-hidden="true"></i> '.$p['ReClout']['DiamondCount'].'</span>
                                        <span class="postlink"><a href="https://bitclout.com/posts/'.$p['PostHashHex'].'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> '.timeAgo($p['TimestampNanos']).'</a></span>
                                    </div>
                            </div>
                        </div>
		    		</div>
		    	</div>
			</item>';
	    }
	    			$commentIcon = ($p['CommentCount'] != 0) ? 'fa-comment' : 'fa-comment-o';
	    			$RecloutCount = ($p['RecloutCount'] != 0) ? 'text-success' : '';
	    			$LikeCount = ($p['LikeCount'] != 0) ? 'fa-heart text-danger' : 'fa-heart-o';
	    			$DiamondCount = ($p['DiamondCount'] != 0) ? 'text-primary' : '';
	    $html .= '  <div class="post-footer mt-3 px-3">
	    				<div class="d-flex justify-content-around flex-row">
	            				<span class="comments"><i class="fa  '.$commentIcon.'" aria-hidden="true"></i> '.$p['CommentCount'].'</span>
	            				<span class="reclouts"><i class="fa fa-retweet '.$RecloutCount.'" aria-hidden="true"></i> '.$p['RecloutCount'].'</span>
	            				<span class="love"><i class="fa '.$LikeCount.'"  aria-hidden="true"></i> '.$p['LikeCount'].'</span>
	            				<span class="diamonds"><i class="fa fa-diamond '.$DiamondCount.'" aria-hidden="true"></i> '.$p['DiamondCount'].'</span>
	            				<span class="postlink"><a href="https://bitclout.com/posts/'.$p['PostHashHex'].'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> '.timeAgo($p['TimestampNanos']).'</a></span>
	            			</div>
	    			</div>
	    		</div>
                </div>
	    	</div>
		</item>';
	endforeach;
    $output = array('status' => 100, 'posts' => $html);
}
else{
	$output = array('status' => 200);
}
echo json_encode($output);
?>