<?php

reason_include_once( 'function_libraries/root_finder.php');

function get_majors_minors()
{
    return array(
        'acctg' =>  'Accounting',
        'afrs'  =>  'Africana Studies',
        'anth'  =>  'Anthropology',
        'art'   =>  'Art',
        'athtr' =>  'Athletic Training',
        'bibl'  =>  'Biblical Languages',
        'bio'   =>  'Biology',
        'bio1'  =>  'Biology (plan 1)',
        'bio2'  =>  'Biology (plan 2)',
        'chem'  =>  'Chemistry',
        'clas'  =>  'Classics',
        'clas1' =>  'Classics (plan 1)',
        'clas2' =>  'Classics (plan 2)',
        'coms'  =>  'Communication Studies',
        'cs'    =>  'Computer Science',
        'dan'   =>  'Dance',
        'degr'  =>  'Degree Seeking',
        'econ1' =>  'Economics (plan 1)',
        'econ2' =>  'Economics (plan 2)',
        'eled'  =>  'Elementary Education',
        'eng1'  =>  'English (plan 1)',
        'eng2'  =>  'English (Writing - Plan 2)',
        'eng3'  =>  'English (Teaching - Plan 3)',
        'envs'  =>  'Environmental Studies',
        'fren'  =>  'French',
        'ger'   =>  'German',
        'hist1' =>  'History (plan 1)',
        'hist2' =>  'History (plan 2)',
        'hlth1' =>  'Health (plan 1)',
        'hlth2' =>  'Health (plan 2)',
        'ima'   =>  'Intermedia Arts',
        'indiv' =>  'Individualized Interdisciplinary',
        'is'    =>  'International Studies',
        'math1' =>  'Mathematics (plan 1)',
        'math2' =>  'Mathematics (plan 2)',
        'math3' =>  'Mathematics (plan 3)',
        'mgt'   =>  'Management',
        'mstat' =>  'Mathematics/Statistics',
        'mus'   =>  'Music',
        'norst' =>  'Nordic Studies',
        'nurs'  =>  'Nursing',
        'pe1'   =>  'Physical Education (plan 1)',
        'pe2'   =>  'Physical Education (plan 2)',
        'phil'  =>  'Philosophy',
        'phys'  =>  'Physics',
        'pols1' =>  'Political Science (plan 1)',
        'pols2' =>  'Political Science (plan 2)',
        'psyc'  =>  'Psychology',
        'rel'   =>  'Religion',
        'rust'  =>  'Russian Studies',
        'soc'   =>  'Sociology',
        'span'  =>  'Spanish',
        'sw'    =>  'Social Work',
        'thd'   =>  'Theatre/Dance',
        'the'   =>  'Theatre',
        'undec' =>  'Undeclared',
        'wgst'  =>  'Women and Gender Studies'
    );
}

/**
 * Removes plans from list of majors
 */
function cleaned_majors(){
    $stripped_arr = array();
    $majors = get_majors_minors();
    // array of majors with separate plans
    $prefix_plans = array(
        'bio'   =>  'bio',
        'clas'  =>  'clas',
        'econ'  =>  'econ',
        'eng'   =>  'eng',
        'hist'  =>  'hist',
        'hlth'  =>  'hlth',
        'math'  =>  'math',
        'pe'    =>  'pe',
        'pols'  =>  'pols'
    );
    foreach ( $majors as $mk => $mv ) {
        foreach ( $prefix_plans as $pk => $pv ) {
            if ( strstr($mk, $pk) ){
                // strip the digits from the $key
                $newk = preg_replace('/\d/', '', $mk);
                // strip the digits then and "plan" text from the value
                $newv = preg_replace('/\(\w*\s?-?\s?[Pp]lan\s\d\)/', '', $mv);
                // remove duplicate $keys
                $stripped_arr[$newk] = $newv;
                unset($majors[$mk]);
            }
        }
    }
    $cleaned = array_merge($majors, $stripped_arr);
    asort($cleaned);
    return $cleaned;
}

function get_statesAP()
{
	return array(
		'AL' => 'Ala.',
		'AK' => 'Alaska',
		'AZ' => 'Ariz.',
		'AR' => 'Ark.',
		'CA' => 'Calif.',
		'CO' => 'Colo.',
		'CT' => 'Conn.',
		'DE' => 'Del.',
		'DC' => 'D.C.',
		'FL' => 'Fla.',
		'GA' => 'Ga.',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Ill.',
		'IN' => 'Ind.',
		'IA' => 'Iowa',
		'KS' => 'Kan.',
		'KY' => 'Ky.',
		'LA' => 'La.',
		'ME' => 'Maine',
		'MD' => 'Md.',
		'MA' => 'Mass.',
		'MI' => 'Mich.',
		'MN' => 'Minn.',
		'MS' => 'Miss.',
		'MO' => 'Mo.',
		'MT' => 'Mont.',
		'NE' => 'Neb.',
		'NV' => 'Nev.',
		'NH' => 'N.H.',
		'NJ' => 'N.J.',
		'NM' => ' N.M.',
		'NY' => 'N.Y.',
		'NC' => 'N.C.',
		'ND' => ' N.D.',
		'OH' => 'Ohio',
		'OK' => ' Okla.',
		'OR' => 'Ore.',
		'PA' => 'Pa.',
		'RI' => 'R.I.',
		'SC' => 'S.C.',
		'SD' => 'S.D.',
		'TN' => 'Tenn.',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vt.',
		'VA' => 'Va.',
		'WA' => 'Wash.',
		'WV' => 'W.Va.',
		'WI' => 'Wis.',
		'WY' => 'Wyo.',
	);
}

function get_luther_spotlight()
// return array containing spotlight information or '' if spotlight doesn't exist on this minisite
{
	$spotlight = luther_get_publication_unique_name("spotlights");
	if (id_of($spotlight, true, false))
	{
		return array( // Spotlights
			'module' => 'publication',
			'related_publication_unique_names' => $spotlight,
			'related_mode' => 'true',
			//'related_title' => '',
			'related_order' => 'random',
			'max_num_items' => 1,
			'markup_generator_info' =>array(
				'list_item' =>array (
					'classname' => 'SpotlightListItemMarkupGenerator',
					'filename' =>'minisite_templates/modules/publication/list_item_markup_generators/spotlight_related.php'
				),
				'list' =>array (
					'classname' => 'RelatedListHTML5SpotlightMarkupGenerator',
					'filename' =>'minisite_templates/modules/publication/publication_list_markup_generators/related_list_html5_spotlight.php'
				),
			),
		);
	}
	else
	{
		return '';
	}
}

function luther_get_publication_unique_name($s)
// allows another minisite to use a popular template like music, alumni, or giving
// by filling in an appropriate headline or spotlight unique publication name
// given the url for a particular minisite landing page (e.g. /music, /kwlc).
// The landing page must be at the root level of the luther site.
// $s is either "headlines" or "spotlights"
// e.g. /reslife becomes "headlines_reslife" or "spotlights_reslife"
{
	$url = get_current_url();
	$url = preg_replace("|\-|", "", $url);   // remove hypens
	if (preg_match("/^https?:\/\/[A-Za-z0-9_\.]+\/([A-Za-z0-9_]+)\/?/", $url, $matches))
	{
		return $s . "_" . $matches[1];
	}
	return '';
}

function luther_is_sports_page()
// checks if url has "/sports" at the root level
{
	$url = get_current_url();
	return preg_match("/^https?:\/\/[A-Za-z0-9_\.]+\/sports\/?/", $url);
}

function luther_video_audio_streaming($event_id, $imgVideo = null, $imgAudio = null)
// append video and audio images if video/audio streaming categories are present for an event
// by default uses fontawesome to display video and audio icons--pass in an image to override
{
	$es = new entity_selector();
	$es->description = 'Selecting categories for event';
	$es->add_type( id_of('category_type'));
	$es->add_right_relationship( $event_id, relationship_id_of('event_to_event_category') );
	$cats = $es->run_one();
	$vstream = '';
	$astream = '';
	$stretch_internet_site = 'lutheradmin';

	foreach( $cats AS $cat )
	{
		if ($cat->get_value('name') == 'Athletics')
		{
			$stretch_internet_site = 'luther';
		}
		if ($cat->get_value('name') == 'Video Streaming')
		{
			if ($imgVideo != null)
			{
				$vstream = '<a title="Video Streaming" href="http://portal.stretchinternet.com/' . $stretch_internet_site . '/"><img class="video_streaming" src="' . $imgVideo .'" alt="Video Streaming"></a>';
			}
			else
			{
				$vstream = '<a title="Video Streaming" href="http://portal.stretchinternet.com/' . $stretch_internet_site . '/"><i class="fa fa-video-camera fa-fw"></i></a>';
			}
		}
		if ($cat->get_value('name') == 'Audio Streaming')
		{
			if ($imgAudio != null)
			{
				$astream = '<a title="Audio Streaming" href="http://www.luther.edu/kwlc/"><img class="audio_streaming" src="' . $imgAudio .'" alt="Audio Streaming"></a>';
			}
			else
			{
				$astream = '<a title="Audio Streaming" href="http://www.luther.edu/kwlc/"><i class="fa fa-headphones fa-fw"></i></a>';
			}
		}
	}
	return $astream . $vstream;
}

function luther_get_event_title($include_site_name = true)
// event title is based on the current root level minisite
{
	if ($include_site_name)
	{
		$url = get_current_url();
		$url = preg_replace("|\-|", " ", $url); // replace hypen with space
		if (preg_match("/^https?:\/\/[A-Za-z0-9_\.]+\/([A-Za-z0-9_]+)\/?/", $url, $matches))
		{
			return 'Upcoming ' . ucfirst($matches[1]) . ' Events';
		}
	}
	return 'Upcoming Events';
}

function luther_get_related_publication($max_num_items = 3)
// set up the related publication template for landing pages
{
	return array(
		'module' => 'publication',
		'markup_generator_info' => array(
			'list_item' => array(
					'classname' => 'MinimalListItemMarkupGenerator',
					'filename' => 'minisite_templates/modules/publication/list_item_markup_generators/minimal.php',
			)
		),
		'related_mode' => true,
		'related_title' => '',
		'max_num_items' => $max_num_items,
	);
}

function luther_get_image_url($image)
// if the image is not found on the local server at WEB_PHOTOSTOCK followed by the image name
// try to find the image url on www.luther.edu
{
	// if images not found locally try pulling from www
	if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $image))
	{
		$image = (on_secure_page()) ? "https://www.luther.edu" . $image : "http://www.luther.edu" . $image;
	}
	return $image;
}

function luther_process_inline_images($content, &$photographer)
// add caption to full-size and thumbnail images
// replace deprecated img align left and right with class
{
	$count = 100;   // no accidental infinite loop
	while (preg_match('/(<[ph]\d?.*?)(<img.*?\/>)(.*?<\/[ph]\d?>)/', $content, $matches) && $count > 0)
	{
		// move the img tag inside a <p> or <h1-6> to a position just before the tag
		$content = preg_replace('/(<[ph]\d?.*?)(<a.*?>)?(<img.*?\/>)(<\/a>)?(.*?<\/[ph]\d?>)/', '$2$3$4$1$5', $content);
		$count--;
	}

	// replace deprecated img align left and right with class
	$content = preg_replace('/<img(.*?)(align="(\w+))"/', '<img'.'$1'.'class="'.'$3'.'" ', $content);
	
	if ($count < 100)
	{
		preg_match_all('/<img\s(alt=".*?")?\s?(src=".*?)(\/reason\/images\/(\d+)(_tn)?\.(jpg|jpeg|gif|png)")\s?(class="(\w+)")?/', $content, $matches, PREG_SET_ORDER);
		
		$image_ids = array();
		$photographer = '';
		$photographers = array();
		$i = 0;
		foreach ($matches as $val)
		{
			// If image appears more than once only add caption one time
			if (array_search($val[4], $image_ids) === FALSE)
			{
				array_push($image_ids, $val[4]);
				$content = luther_add_inline_caption($content, $val[4], $val[1], $photographers[$i]);
				$i++;
			}
			
		}
		// if all embedded photos have the same photographer set $photographer otherwise leave field blank
		if (count(array_unique($photographers)) == 1)
		{
			$photographer = $photographers[0];
		}
	}
	return $content;
}

function luther_add_inline_caption($content, $image_id, $caption, &$photographer)
{
	$es = new entity_selector();
	$es->add_type(id_of('image'));
	$es->add_relation('entity.id = ' . $image_id);
	$result = $es->run_one();
	foreach( $result AS $id => $image )
	{
		if (preg_match("/hide_caption/", $image->get_value('keywords')))
		{
			preg_match('/<img\s('.preg_quote($caption, '/').')?\s?(src=".*?)(\/reason\/images\/' . $id . '(_tn)?\.(jpg|jpeg|gif|png)")\s?(class="(\w+)")?\s*\/>/', $content, $matches);
			if (count($matches) >= 8 && ($matches[7] == "left" || $matches[7] == "right"))
			{
				$content = preg_replace('/<img\s('.preg_quote($caption, '/').')?\s?(src=".*?)(\/reason\/images\/' . $id . '(_tn)?\.(jpg|jpeg|gif|png)")\s?(class="(\w+)")?\s*\/>/', '<figure $6><img alt="'.$image->get_value('description').'" $2$3 /></figure>', $content);
			}
			else
			{
				$content = preg_replace('/<img\s('.preg_quote($caption, '/').')?\s?(src=".*?)(\/reason\/images\/' . $id . '(_tn)?\.(jpg|jpeg|gif|png)")\s*\/>/', '<figure><img alt="'.$image->get_value('description').'" $2$3 /></figure>', $content);
			}
		}
		else
		{
			preg_match('/<img\s('.preg_quote($caption, '/').')?\s?(src=".*?)(\/reason\/images\/' . $id . '(_tn)?\.(jpg|jpeg|gif|png)")\s?(class="(\w+)")?\s*\/>/', $content, $matches);
			if (count($matches) >= 8 && ($matches[7] == "left" || $matches[7] == "right"))
			{
				$content = preg_replace('/<img\s('.preg_quote($caption, '/').')?\s?(src=".*?)(\/reason\/images\/' . $id . '(_tn)?\.(jpg|jpeg|gif|png)")\s?(class="(\w+)")?\s*\/>/', '<figure $6><img alt="'.$image->get_value('description').'" $2$3 /><figcaption>'.$image->get_value('description').'</figcaption></figure>', $content);
			}
			else
			{
				$content = preg_replace('/<img\s('.preg_quote($caption, '/').')?\s?(src=".*?)(\/reason\/images\/' . $id . '(_tn)?\.(jpg|jpeg|gif|png)")\s*\/>/', '<figure><img alt="'.$image->get_value('description').'" $2$3 /><figcaption>'.$image->get_value('description').'</figcaption></figure>', $content);
			}			
		}
		$photographer = $image->get_value('author');
	}
	return $content;
}

function luther_is_local_ip()
// determine if ip address is luther college or Decorah area
// used for ReachLocal remarketing pixel on admissions site
{
	if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' // localhost
		// private
		|| preg_match("/^(10\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(172\.(1[6-9]|2[0-9]|3[01])\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(192\.168\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5])\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Luther Campus
		|| preg_match("/^(192\.203\.196\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(198\.133\.77\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(209\.56\.59\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(74\.207\.(3[2-9]|4[0-9]|5[0-9]|6[0-3])\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Decorah: Go to http://www.my-ip-address-is.com/city/Iowa/Decorah-IP-Addresses
		|| preg_match("/^(65\.116\.8[89]\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(65\.166\.58\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(66\.43\.231\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(66\.43\.252\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(67\.54\.189\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(67\.128\.219\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(69\.66\.77\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(72\.166\.100\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(75\.175\.212\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(173\.17\.36\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(173\.19\.[49]6\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(173\.19\.232\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(66\.43\.252\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(199\.120\.71\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(204\.248\.125\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(205\.243\.127\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(205\.246\.174\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(207\.165\.178\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(207\.177\.54\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(209\.152\.65\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(216\.51\.150\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(216\.161\.207\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(216\.248\.94\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Calmar: Go to http://www.my-ip-address-is.com/city/Iowa/Calmar-IP-Addresses
		|| preg_match("/^(4\.252\.133\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(199\.201\.208\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(205\.221\.68\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(207\.28\.22\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(207\.165\.228\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Cresco: Go to http://www.my-ip-address-is.com/city/Iowa/Cresco-IP-Addresses
		|| preg_match("/^(4\.158\.16\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(4\.158\.28\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(63\.86\.22\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(67\.224\.57\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(69\.66\.22\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(71\.7\.44\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(173\.19\.105\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(173\.22\.137\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(204\.248\.127\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(208\.161\.56\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Ossian: Go to http://www.my-ip-address-is.com/city/Iowa/Ossian-IP-Addresses
		|| preg_match("/^(207\.28\.13\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Waukon: Go to http://www.my-ip-address-is.com/city/Iowa/Waukon-IP-Addresses
		|| preg_match("/^(75\.167\.203\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(216\.51\.201\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// West Union: Go to http://www.my-ip-address-is.com/city/Iowa/West+Union-IP-Addresses
		|| preg_match("/^(205\.221\.67\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Harmony: Go to http://www.my-ip-address-is.com/city/Minnesota/Harmony-IP-Addresses
		|| preg_match("/^(12\.157\.197\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(204\.248\.121\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Mabel: Go to http://www.my-ip-address-is.com/city/Minnesota/Mabel-IP-Addresses
		|| preg_match("/^(204\.248\.126\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(205\.243\.117\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		// Spring Grove: Go to http://www.my-ip-address-is.com/city/Minnesota/Spring+Grove-IP-Addresses
		|| preg_match("/^(204\.248\.117\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(204\.248\.124\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(205\.243\.121\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR'])
		|| preg_match("/^(208\.74\.240\.([01]?[0-9]?[0-9]|2[0-4][0-9]|25[0-5]))$/", $_SERVER['REMOTE_ADDR']))
	{
		return true;
	}
	return false;
}

function luther_is_mobile_device()
// returns true if browsing with mobile device, otherwise false
// see http://detectmobilebrowsers.com/ for a list of recent mobile browsers
{
	return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])
			|| preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4)));
}

function get_directory_images($folder)
// given a folder, returns an array of all image files in the folder
{
	$extList = array();
	$extList['gif'] = 'image/gif';
	$extList['jpg'] = 'image/jpeg';
	$extList['jpeg'] = 'image/jpeg';
	$extList['png'] = 'image/png';

	$handle = opendir($folder);
	while (false !== ($file = readdir($handle)))
	{
		$file_info = pathinfo($file);
		if (isset($extList[strtolower($file_info['extension'])]))
		{
			$fileList[] = $file;
		}
	}
	closedir($handle);
	return $fileList;
}

function google_analytics()
{
	if (!preg_match("/^www.luther.edu$/", REASON_HOST, $matches))
	{
		echo '<!-- '. REASON_HOST.': google analytics code goes here on production servers -->'."\n";
		return;
	}

	echo '<script type="text/javascript">'."\n";

	echo 'var _gaq = _gaq || [];'."\n";
	echo "_gaq.push(['_setAccount', 'UA-129020-8']);"."\n";
	echo "_gaq.push(['_setDomainName', 'luther.edu']);"."\n";
	echo "_gaq.push(['_setAllowLinker', true]);"."\n";
	echo "_gaq.push(['_trackPageview']);"."\n";

	echo '(function() {'."\n";
	echo "var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;"."\n";
	echo "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';"."\n";
	echo "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);"."\n";
	echo '})();'."\n";

	echo '</script>'."\n";
}

function emergency_preempt()
// Display one or more site-wide preemptive emergency messages
// if one or more text blurbs are placed on the page /preempt
{

	$site_id = get_site_id_from_url("/preempt");
	$page_id = root_finder( $site_id );   // see 'lib/core/function_libraries/root_finder.php'

	$es = new entity_selector();
	$es->add_type(id_of('text_blurb'));
	$es->add_right_relationship($page_id, relationship_id_of('minisite_page_to_text_blurb'));
	$result = $es->run_one();

	if ($result == null)
	{
		return;
	}

	echo '<div id="emergencyPreempt" class="emergency flash-notice">'."\n";
	echo '<div class="callout callout-danger">'."\n";
	foreach( $result AS $id => $page )
	{
		echo $page->get_value('content')."\n";
	}
	echo '</div>'."\n";
	echo '</div>'."\n";
}

function handle_ie8()
// if browser is ie 6-8 or display no longer supported message
// change regex when version 16 comes along
{
	if(preg_match('/(?i)msie [6-8]/',$_SERVER['HTTP_USER_AGENT']))
	{
		echo '<div id="emergencyPreempt" class="flash-notice">'."\n";
		echo '<div class="callout callout-warning ie8-alert">'."\n";
		echo 'Browser support for this version of Internet Explorer is no longer supported. Please upgrade to IE 9 or newer.'."\n";
		echo '</div>'."\n";
		echo '</div>  <!-- class="flash-notice"-->'."\n";
	}

}

function luther_shorten_string($text, $length, $append)
// shorten a string called $text to a word boundary if longer than $length.
// append a string to the end (like " ..." or "Read more...")
{
	if (strlen($text) > $length)
	{
		for ($i = $length; $text[$i] != ' '; $i--);
		$text = substr($text, 0, $i) . $append;
	}
	return $text;
}

function get_athlete_tooltip($player, $site_name)
// adds athlete tooltip utilizing Foundation framework
{
	$stAP = get_statesAP();
	$tip = '';
	$tip .= "<h5 class='athlete_name'>" . $player['athlete_first_name'] . " " . $player['athlete_last_name'] . "</h5>"."\n";
	if (!empty($player['image_id']))
	{
		$image = get_entity_by_id($player['image_id']);
		$thumb = luther_get_image_url(WEB_PHOTOSTOCK . $player['image_id'] . '_tn.' . $image['image_type']);
		$tip .= "<img class='athlete_image' src='" . $thumb . "' />"."\n";
	}
	if ($player['athlete_position_event'] && ($position_event = get_sport_position_event_full_name($site_name)) != null)
		$tip .= "<p class='athlete_position_event'>". $position_event[$player['athlete_position_event']] . "</p>"."\n";
	$tip .= "<p class='athlete_class_year'>". $player['athlete_class_year']."</p>"."\n";
	$tip .= "<p class='athlete_hometown'>". $player['athlete_hometown_city'];
	if (array_key_exists($player['athlete_hometown_state'], $stAP))
	{
		$tip .= ", ". $stAP[$player['athlete_hometown_state']];
	}
	$tip .= "</p>"."\n";
	$tip .= "<p class='athlete_high_school'>". $player['athlete_high_school']."</p>"."\n";
	return $tip;
}

function get_sport_position_event_full_name($site_name)
// replaces abbreviated position or event with the full name
{
	$positions = null;
	if ($site_name == 'sport_baseball_men' || $site_name == 'sport_softball_women')
	{
		$positions = array(
				'P' => 'Pitcher',
				'C' => 'Catcher',
				'IF' => 'Infield',
				'1B' => 'First Base',
				'2B' => 'Second Base',
				'3B' => 'Third Base',
				'SS' => 'Shortstop',
				'OF' => 'Outfield',
		);
	}
	else if ($site_name == 'sport_basketball_men' || $site_name == 'sport_basketball_women')
	{
		$positions = array(
				'C' => 'Center',
				'F' => 'Forward',
				'G' => 'Guard',
		);
	}
	else if ($site_name == 'sport_football_men' )
	{
		$positions = array(
				'DB' => 'Defensive Back',
				'DL' => 'Defensive Line',
				'FB' => 'Fullback',
				'K' => 'Kicker',
				'LB' => 'Linebacker',
				'OL' => 'Offensive Line',
				'QB' => 'Quarterback',
				'RB' => 'Running Back',
				'TE' => 'Tight End',
				'WR' => 'Wide Receiver',
		);
	}
	else if ($site_name == 'sport_soccer_men' || $site_name == 'sport_soccer_women')
	{
		$positions = array(
				'GK' => 'Goalkeeper',
				'D' => 'Defender',
				'MF' => 'Midfielder',
				'F' => 'Forward',
		);
	}
	else if ($site_name == 'sport_volleyball_women' )
	{
		$positions = array(
				'DS' => 'Defensive Specialist',
				'L' => 'Libero',
				'MB' => 'Middle Blocker',
				'OH' => 'Outside Hitter',
				'R' => 'Right Side Hitter',
				'S' => 'Setter',
		);
	}
	else if ($site_name == 'sport_swimmingdiving_men' || $site_name == 'sport_swimmingdiving_women')
	{
		$positions = array(
				'Fl' => 'Butterfly',
				'Bk' => 'Backstroke',
				'Br' => 'Breaststroke',
				'Fr' => 'Freestyle',
				'IM' => 'Individual Medley',
				'D' => 'Diving',
		);
	}
	else if ($site_name == 'sport_trackfield_men' || $site_name == 'sport_trackfield_women')
	{
		$positions = array(
				'D' => 'Distance',
				'H' => 'Hurdles',
				'J' => 'Jumps',
				'MD' => 'Mid-distance',
				'ME' => 'Multi-events',
				'PV' => 'Pole Vault',
				'S' => 'Sprints',
				'T' => 'Throws',
		);
	}
	return $positions;
}
