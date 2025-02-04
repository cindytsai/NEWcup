<?php
include_once("database.php");

function getTreeTable($row, $type, $first, $second) {
	$content = '';
	if ($type == 1) {
		$content .= '<tr><td id="unit'.$row.'">'.$first[0].'</td><td>'.$first[1].'</td>';
		for ($a = 1; $a <= 9; $a++) {
			$content .= '<td id="p'.($row*2-1).'_'.$a.'"></td>';
		}
		$content .= '</tr><tr><td>'.$second[0].'</td><td>'.$second[1].'</td>';
		for ($b = 1; $b <= 9; $b++) {
			$content .= '<td id="p'.($row*2).'_'.$b.'"></td>';
		}
	}
	elseif ($type == 2) {
		$content .= '<tr><td>'.$first[0].'</td><td>'.$first[1].'</td>';
		for ($a = 1; $a <= 9; $a++) {
			$content .= '<td id="p'.($row*2-1).'_'.$a.'"></td>';
		}
		$content .= '</tr><tr><td>'.$second[0].'</td><td>'.$second[1].'</td>';
		for ($b = 1; $b <= 9; $b++) {
			$content .= '<td id="p'.($row*2).'_'.$b.'"></td>';
		}
	}
	elseif ($type == 3) {
		$content .= '<tr><td id="unit'.$row.'">'.$first[0].'</td>';
		for ($a = 1; $a <= 9; $a++) {
			$content .= '<td id="p'.($row*2-1).'_'.$a.'"></td>';
		}
		$content .= '</tr><tr><td>'.$second[0].'</td>';
		for ($b = 1; $b <= 9; $b++) {
			$content .= '<td id="p'.($row*2).'_'.$b.'"></td>';
		}
	}
	$content .= '</tr>';
	return $content;
}

function makePublic($account, $gameno) {
	$type = getGametype($account, $gameno);
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="resource/tournament.css"><link rel="stylesheet" type="text/css" href="resource/custom.css"></head><body>';
	$content = cyclePublicContent($account, $gameno);
	$amount = getAmount($account, $gameno);
	$distribute = distribute($amount);
	$roundAmount = $distribute['round'];
	$end = '</body><script src="resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($account.'/'.$gameno."/public.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function makeEdit($account, $gameno) {
	$type = getGametype($account, $gameno);
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="resource/tournament.css"><link rel="stylesheet" type="text/css" href="resource/custom.css"></head><body>';
	$content = cycleEditContent($account, $gameno);
	$amount = getAmount($account, $gameno);
	$distribute = distribute($amount);
	$roundAmount = $distribute['round'];
	$end = '</body><script src="resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($account.'/'.$gameno . "/edit.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function cyclePublicContent($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$playtype = getPlaytype($account, $gameno);
	$content = '<script src="resource/custom.js"></script>';
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	$label = array(' ', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$total = 1;
	$game = 1;
	$pos = 1;
	$rank1 = array();
	$rank2 = array();
	$rank3 = array();
	for ($i = 1; $i <= $distribute['4_2']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$query4 = queryContentSingle($account, $gameno, $pos+3);
			$square = file_get_contents("resource/single_square_view.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
			$square = str_replace('[name'.$pos.']', $query1['name'], $square);
			$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
			$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
			$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
			$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
			$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
			$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$query4 = queryContentDouble($account, $gameno, $pos+3);
			$square = file_get_contents("resource/double_square_view.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.'u]', $query1['unitu'], $square);
			$square = str_replace('[unit'.$pos.'d]', $query1['unitd'], $square);
			$square = str_replace('[name'.$pos.'u]', $query1['nameu'], $square);
			$square = str_replace('[name'.$pos.'d]', $query1['named'], $square);
			$square = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $square);
			$square = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $square);
			$square = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $square);
			$square = str_replace('[name'.($pos+1).'d]', $query2['named'], $square);
			$square = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $square);
			$square = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $square);
			$square = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $square);
			$square = str_replace('[name'.($pos+2).'d]', $query3['named'], $square);
			$square = str_replace('[unit'.($pos+3).'u]', $query4['unitu'], $square);
			$square = str_replace('[unit'.($pos+3).'d]', $query4['unitd'], $square);
			$square = str_replace('[name'.($pos+3).'u]', $query4['nameu'], $square);
			$square = str_replace('[name'.($pos+3).'d]', $query4['named'], $square);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$query4 = queryContentGroup($account, $gameno, $pos+3);
			$square = file_get_contents("resource/group_square_view.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1, $square);
			$square = str_replace('[unit'.($pos+1).']', $query2, $square);
			$square = str_replace('[unit'.($pos+2).']', $query3, $square);
			$square = str_replace('[unit'.($pos+3).']', $query4, $square);
		}
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $game+1, $square);
		$square = str_replace('[game3]', $gap + $game, $square);
		$square = str_replace('[game4]', $gap + $game+1, $square);
		$square = str_replace('[game5]', 2*$gap + $game, $square);
		$square = str_replace('[game6]', 2*$gap + $game+1, $square);
		$content .= $square;
		array_push($rank1, $label[$total].'冠');
		array_push($rank3, $label[$total].'亞');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['4_1']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$query4 = queryContentSingle($account, $gameno, $pos+3);
			$square = file_get_contents("resource/single_square_view.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
			$square = str_replace('[name'.$pos.']', $query1['name'], $square);
			$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
			$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
			$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
			$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
			$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
			$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$query4 = queryContentDouble($account, $gameno, $pos+3);
			$square = file_get_contents("resource/double_square_view.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.'u]', $query1['unitu'], $square);
			$square = str_replace('[unit'.$pos.'d]', $query1['unitd'], $square);
			$square = str_replace('[name'.$pos.'u]', $query1['nameu'], $square);
			$square = str_replace('[name'.$pos.'d]', $query1['named'], $square);
			$square = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $square);
			$square = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $square);
			$square = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $square);
			$square = str_replace('[name'.($pos+1).'d]', $query2['named'], $square);
			$square = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $square);
			$square = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $square);
			$square = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $square);
			$square = str_replace('[name'.($pos+2).'d]', $query3['named'], $square);
			$square = str_replace('[unit'.($pos+3).'u]', $query4['unitu'], $square);
			$square = str_replace('[unit'.($pos+3).'d]', $query4['unitd'], $square);
			$square = str_replace('[name'.($pos+3).'u]', $query4['nameu'], $square);
			$square = str_replace('[name'.($pos+3).'d]', $query4['named'], $square);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$query4 = queryContentGroup($account, $gameno, $pos+3);
			$square = file_get_contents("resource/group_square_view.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1, $square);
			$square = str_replace('[unit'.($pos+1).']', $query2, $square);
			$square = str_replace('[unit'.($pos+2).']', $query3, $square);
			$square = str_replace('[unit'.($pos+3).']', $query4, $square);
		}
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $game+1, $square);
		$square = str_replace('[game3]', $gap + $game, $square);
		$square = str_replace('[game4]', $gap + $game+1, $square);
		$square = str_replace('[game5]', 2*$gap + $game, $square);
		$square = str_replace('[game6]', 2*$gap + $game+1, $square);
		$content .= $square;
		array_push($rank1, $label[$total].'冠');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['3_1']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/single_triangle_view.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
			$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/double_triangle_view.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.'u]', $query1['unitu'], $triangle);
			$triangle = str_replace('[unit'.$pos.'d]', $query1['unitd'], $triangle);
			$triangle = str_replace('[name'.$pos.'u]', $query1['nameu'], $triangle);
			$triangle = str_replace('[name'.$pos.'d]', $query1['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'d]', $query2['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'d]', $query3['named'], $triangle);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/group_triangle_view.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1, $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2, $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3, $triangle);
		}
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$content .= $triangle;
		array_push($rank2, $label[$total].'冠');
		$total++;
		$game++;
		$pos += 3;
	}
	for ($i = 1; $i <= $distribute['3_2']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/single_triangle_view.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
			$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/double_triangle_view.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.'u]', $query1['unitu'], $triangle);
			$triangle = str_replace('[unit'.$pos.'d]', $query1['unitd'], $triangle);
			$triangle = str_replace('[name'.$pos.'u]', $query1['nameu'], $triangle);
			$triangle = str_replace('[name'.$pos.'d]', $query1['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'d]', $query2['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'d]', $query3['named'], $triangle);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/group_triangle_view.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1, $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2, $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3, $triangle);
		}
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$content .= $triangle;
		array_push($rank2, $label[$total].'冠');
		array_push($rank3, $label[$total].'亞');
		$total++;
		$game++;
		$pos += 3;
	}
	$up = arrange($rank1, $rank2, $rank3);
	if ($playtype == 'A') {
		$content .= '<table><tr><td>單位</td><td>名稱</td></tr>';
	}
	elseif ($playtype == 'B') {
		$content .= '<table><tr><td>單位</td><td>名稱</td></tr>';
	}
	elseif ($playtype == 'C') {
		$content .= '<table><tr><td>單位</td></tr>';
	}
	for ($i = 1; $i <= $distribute['round']; $i++) {
		$state = queryState($account, $gameno, 3*$gap+ceil($i/2));
		if ($playtype == 'A') {
			if (empty($state['above'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['above'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentSingle($account, $gameno, $state['above']);
				$content .= getTreeTable($i, 1, array($query['unit'], $query['name']), array('', ''));
			}
			$i++;
			if (empty($state['below'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['below'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentSingle($account, $gameno, $state['below']);
				$content .= getTreeTable($i, 1, array($query['unit'], $query['name']), array('', ''));
			}
		}
		elseif ($playtype == 'B') {
			if (empty($state['above'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['above'] == -1){
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentDouble($account, $gameno, $state['above']);
				$content .= getTreeTable($i, 1, array($query['unitu'], $query['nameu']), array($query['unitd'], $query['named']));
			}
			$i++;
			if (empty($state['below'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['below'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentDouble($account, $gameno, $state['below']);
				$content .= getTreeTable($i, 1, array($query['unitu'], $query['nameu']), array($query['unitd'], $query['named']));
			}
		}
		elseif ($playtype == 'C') {
			if (empty($state['above'])) {
				$content .= getTreeTable($i, 3, array(array_pop($up)), array(''));
			}
			elseif ($state['above'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 3, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentGroup($account, $gameno, $state['above']);
				$content .= getTreeTable($i, 3, array($query), array(''));
			}
			$i++;
			if (empty($state['below'])) {
				$content .= getTreeTable($i, 3, array(array_pop($up)), array(''));
			}
			elseif ($state['below'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 3, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentGroup($account, $gameno, $state['below']);
				$content .= getTreeTable($i, 3, array($query), array(''));
			}
		}
	}
	$content = cycleSetPlayNo($account, $gameno, $content, $distribute['round']);
	$content .= '</table><button onclick="window.open(\'index.php?host='.$account.'&gameno='.$gameno.'&type=game\')">賽程時間表</button>';
	return $content;
}

function cycleEditContent($account, $gameno) {
	$amount = getAmount($account, $gameno);
	$playtype = getPlaytype($account, $gameno);
	$content = '<script src="resource/custom.js"></script>';
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	$label = array(' ', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
	$total = 1;
	$game = 1;
	$pos = 1;
	$rank1 = array();
	$rank2 = array();
	$rank3 = array();
	for ($i = 1; $i <= $distribute['4_2']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$query4 = queryContentSingle($account, $gameno, $pos+3);
			$square = file_get_contents("resource/single_square_edit.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
			$square = str_replace('[name'.$pos.']', $query1['name'], $square);
			$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
			$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
			$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
			$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
			$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
			$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$query4 = queryContentDouble($account, $gameno, $pos+3);
			$square = file_get_contents("resource/double_square_edit.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.'u]', $query1['unitu'], $square);
			$square = str_replace('[unit'.$pos.'d]', $query1['unitd'], $square);
			$square = str_replace('[name'.$pos.'u]', $query1['nameu'], $square);
			$square = str_replace('[name'.$pos.'d]', $query1['named'], $square);
			$square = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $square);
			$square = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $square);
			$square = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $square);
			$square = str_replace('[name'.($pos+1).'d]', $query2['named'], $square);
			$square = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $square);
			$square = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $square);
			$square = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $square);
			$square = str_replace('[name'.($pos+2).'d]', $query3['named'], $square);
			$square = str_replace('[unit'.($pos+3).'u]', $query4['unitu'], $square);
			$square = str_replace('[unit'.($pos+3).'d]', $query4['unitd'], $square);
			$square = str_replace('[name'.($pos+3).'u]', $query4['nameu'], $square);
			$square = str_replace('[name'.($pos+3).'d]', $query4['named'], $square);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$query4 = queryContentGroup($account, $gameno, $pos+3);
			$square = file_get_contents("resource/group_square_edit.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1, $square);
			$square = str_replace('[unit'.($pos+1).']', $query2, $square);
			$square = str_replace('[unit'.($pos+2).']', $query3, $square);
			$square = str_replace('[unit'.($pos+3).']', $query4, $square);
		}
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $game+1, $square);
		$square = str_replace('[game3]', $gap + $game, $square);
		$square = str_replace('[game4]', $gap + $game+1, $square);
		$square = str_replace('[game5]', 2*$gap + $game, $square);
		$square = str_replace('[game6]', 2*$gap + $game+1, $square);
		$content .= $square;
		array_push($rank1, $label[$total].'冠');
		array_push($rank3, $label[$total].'亞');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['4_1']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$query4 = queryContentSingle($account, $gameno, $pos+3);
			$square = file_get_contents("resource/single_square_edit.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1['unit'], $square);
			$square = str_replace('[name'.$pos.']', $query1['name'], $square);
			$square = str_replace('[unit'.($pos+1).']', $query2['unit'], $square);
			$square = str_replace('[name'.($pos+1).']', $query2['name'], $square);
			$square = str_replace('[unit'.($pos+2).']', $query3['unit'], $square);
			$square = str_replace('[name'.($pos+2).']', $query3['name'], $square);
			$square = str_replace('[unit'.($pos+3).']', $query4['unit'], $square);
			$square = str_replace('[name'.($pos+3).']', $query4['name'], $square);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$query4 = queryContentDouble($account, $gameno, $pos+3);
			$square = file_get_contents("resource/double_square_edit.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.'u]', $query1['unitu'], $square);
			$square = str_replace('[unit'.$pos.'d]', $query1['unitd'], $square);
			$square = str_replace('[name'.$pos.'u]', $query1['nameu'], $square);
			$square = str_replace('[name'.$pos.'d]', $query1['named'], $square);
			$square = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $square);
			$square = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $square);
			$square = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $square);
			$square = str_replace('[name'.($pos+1).'d]', $query2['named'], $square);
			$square = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $square);
			$square = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $square);
			$square = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $square);
			$square = str_replace('[name'.($pos+2).'d]', $query3['named'], $square);
			$square = str_replace('[unit'.($pos+3).'u]', $query4['unitu'], $square);
			$square = str_replace('[unit'.($pos+3).'d]', $query4['unitd'], $square);
			$square = str_replace('[name'.($pos+3).'u]', $query4['nameu'], $square);
			$square = str_replace('[name'.($pos+3).'d]', $query4['named'], $square);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$query4 = queryContentGroup($account, $gameno, $pos+3);
			$square = file_get_contents("resource/group_square_edit.html");
			$square = str_replace('[pos1]', $pos, $square);
			$square = str_replace('[pos2]', $pos+1, $square);
			$square = str_replace('[pos3]', $pos+2, $square);
			$square = str_replace('[pos4]', $pos+3, $square);
			$square = str_replace('[unit'.$pos.']', $query1, $square);
			$square = str_replace('[unit'.($pos+1).']', $query2, $square);
			$square = str_replace('[unit'.($pos+2).']', $query3, $square);
			$square = str_replace('[unit'.($pos+3).']', $query4, $square);
		}
		$square = str_replace('[label]', $label[$total], $square);
		$square = str_replace('[game1]', $game, $square);
		$square = str_replace('[game2]', $game+1, $square);
		$square = str_replace('[game3]', $gap + $game, $square);
		$square = str_replace('[game4]', $gap + $game+1, $square);
		$square = str_replace('[game5]', 2*$gap + $game, $square);
		$square = str_replace('[game6]', 2*$gap + $game+1, $square);
		$content .= $square;
		array_push($rank1, $label[$total].'冠');
		$total++;
		$game += 2;
		$pos += 4;
	}
	for ($i = 1; $i <= $distribute['3_1']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/single_triangle_edit.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
			$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/double_triangle_edit.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.'u]', $query1['unitu'], $triangle);
			$triangle = str_replace('[unit'.$pos.'d]', $query1['unitd'], $triangle);
			$triangle = str_replace('[name'.$pos.'u]', $query1['nameu'], $triangle);
			$triangle = str_replace('[name'.$pos.'d]', $query1['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'d]', $query2['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'d]', $query3['named'], $triangle);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/group_triangle_edit.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1, $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2, $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3, $triangle);
		}
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$content .= $triangle;
		array_push($rank2, $label[$total].'冠');
		$total++;
		$game++;
		$pos += 3;
	}
	for ($i = 1; $i <= $distribute['3_2']; $i++) {
		if ($playtype == 'A') {
			$query1 = queryContentSingle($account, $gameno, $pos);
			$query2 = queryContentSingle($account, $gameno, $pos+1);
			$query3 = queryContentSingle($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/single_triangle_edit.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1['unit'], $triangle);
			$triangle = str_replace('[name'.$pos.']', $query1['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+1).']', $query2['name'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3['unit'], $triangle);
			$triangle = str_replace('[name'.($pos+2).']', $query3['name'], $triangle);
		}
		elseif ($playtype == 'B') {
			$query1 = queryContentDouble($account, $gameno, $pos);
			$query2 = queryContentDouble($account, $gameno, $pos+1);
			$query3 = queryContentDouble($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/double_triangle_edit.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.'u]', $query1['unitu'], $triangle);
			$triangle = str_replace('[unit'.$pos.'d]', $query1['unitd'], $triangle);
			$triangle = str_replace('[name'.$pos.'u]', $query1['nameu'], $triangle);
			$triangle = str_replace('[name'.$pos.'d]', $query1['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'u]', $query2['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+1).'d]', $query2['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'u]', $query2['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+1).'d]', $query2['named'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'u]', $query3['unitu'], $triangle);
			$triangle = str_replace('[unit'.($pos+2).'d]', $query3['unitd'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'u]', $query3['nameu'], $triangle);
			$triangle = str_replace('[name'.($pos+2).'d]', $query3['named'], $triangle);
		}
		elseif ($playtype == 'C') {
			$query1 = queryContentGroup($account, $gameno, $pos);
			$query2 = queryContentGroup($account, $gameno, $pos+1);
			$query3 = queryContentGroup($account, $gameno, $pos+2);
			$triangle = file_get_contents("resource/group_triangle_edit.html");
			$triangle = str_replace('[pos1]', $pos, $triangle);
			$triangle = str_replace('[pos2]', $pos+1, $triangle);
			$triangle = str_replace('[pos3]', $pos+2, $triangle);
			$triangle = str_replace('[unit'.$pos.']', $query1, $triangle);
			$triangle = str_replace('[unit'.($pos+1).']', $query2, $triangle);
			$triangle = str_replace('[unit'.($pos+2).']', $query3, $triangle);
		}
		$triangle = str_replace('[label]', $label[$total], $triangle);
		$triangle = str_replace('[game1]', $game, $triangle);
		$triangle = str_replace('[game2]', $gap + $game, $triangle);
		$triangle = str_replace('[game3]', 2*$gap + $game, $triangle);
		$content .= $triangle;
		array_push($rank2, $label[$total].'冠');
		array_push($rank3, $label[$total].'亞');
		$total++;
		$game++;
		$pos += 3;
	}
	$up = arrange($rank1, $rank2, $rank3);
	if ($playtype == 'A') {
		$content .= '<table><tr><td>單位</td><td>名稱</td></tr>';
	}
	elseif ($playtype == 'B') {
		$content .= '<table><tr><td>單位</td><td>名稱</td></tr>';
	}
	elseif ($playtype == 'C') {
		$content .= '<table><tr><td>單位</td></tr>';
	}
	for ($i = 1; $i <= $distribute['round']; $i++) {
		$state = queryState($account, $gameno, 3*$gap+ceil($i/2));
		if ($playtype == 'A') {
			if (empty($state['above'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['above'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentSingle($account, $gameno, $state['above']);
				$content .= getTreeTable($i, 1, array($query['unit'], $query['name']), array('', ''));
			}
			$i++;
			if (empty($state['below'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['below'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentSingle($account, $gameno, $state['below']);
				$content .= getTreeTable($i, 1, array($query['unit'], $query['name']), array('', ''));
			}
		}
		elseif ($playtype == 'B') {
			if (empty($state['above'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['above'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentDouble($account, $gameno, $state['above']);
				$content .= getTreeTable($i, 1, array($query['unitu'], $query['nameu']), array($query['unitd'], $query['named']));
			}
			$i++;
			if (empty($state['below'])) {
				$content .= getTreeTable($i, 1, array(array_pop($up), ''), array('', ''));
			}
			elseif ($state['below'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 1, array('W/O', ''), array('', ''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentDouble($account, $gameno, $state['below']);
				$content .= getTreeTable($i, 1, array($query['unitu'], $query['nameu']), array($query['unitd'], $query['named']));
			}
		}
		elseif ($playtype == 'C') {
			if (empty($state['above'])) {
				$content .= getTreeTable($i, 2, array(array_pop($up)), array(''));
			}
			elseif ($state['above'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 2, array('W/O'), array(''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentGroup($account, $gameno, $state['above']);
				$content .= getTreeTable($i, 2, array($query), array(''));
			}
			$i++;
			if (empty($state['below'])) {
				$content .= getTreeTable($i, 2, array(array_pop($up)), array(''));
			}
			elseif ($state['below'] == -1) {
				$omit = array_pop($up);
				$content .= getTreeTable($i, 2, array('W/O'), array(''));
			}
			else {
				$omit = array_pop($up);
				$query = queryContentGroup($account, $gameno, $state['below']);
				$content .= getTreeTable($i, 2, array($query), array(''));
			}
		}
	}
	$content = cycleSetPlayNo($account, $gameno, $content, $distribute['round']);
	$content = cycleSetScoreInput($account, $gameno, $content, $distribute['round']);
	$content .= '</table>
	<div>調動競賽人員位置：將位置代號為<input type="text" id="swapnum1">與<input type="text" id="swapnum2">之選手對調。
	<button onclick="swap(\''.$gameno.'\')">執行調動</button></div>
	<button onclick="update(\''.$gameno.'\')">確定更新</button>
	<button onclick="window.open(\'index.php?host='.$account.'&gameno='.$gameno.'&type=game\')">賽程時間表</button>
	<div id="cover"><div id="dialog">請稍候...</div></div>';
	return $content;
}

function processUnit($unit) {
	if ($unit == 'none') {
		return '';
	}
	else {
		return $unit;
	}
}

function processName($name) {
	if ($name == 'none') {
		return 'Bye';
	}
	else {
		return $name;
	}
}

function rank($amount) {
	$return = array();
	array_push($return, 1);
	$temp = array();
	for ($i = 1; $i <= log($amount, 2); $i++) {
		while (count($return)) {
			$value = array_shift($return);
			array_push($temp, $value);
			array_push($temp, pow(2, $i)+1-$value);
		}
		$return = $temp;
		$temp = array();
	}
	return $return;
}

function arrange($rank1, $rank2, $rank3) {
	$rank_count = count($rank1) + count($rank2) + count($rank3);
	$rank3 = array_merge(array_slice($rank3, ceil(count($rank3)/2)), array_slice($rank3, 0, ceil(count($rank3)/2)));
	$result = array_merge($rank1, $rank2, $rank3);
	$up = array();
	if (count($rank1) + count($rank3) <= 3) {
		$up = array_merge($rank1, $rank2, $rank3);
		$rank = rank($rank_count);
		for ($i = 0; $i < count($rank); $i++) {
			$result[$rank[$i]] = array_shift($up);
		}
	}
	else {
		$rank = rank($rank_count/2);
		while (count($rank1)) {
			array_push($up, array_shift($rank1));
			if (count($rank3)) {
				array_push($up, array_shift($rank3));
			}
			elseif (count($rank2)) {
				array_push($up, array_shift($rank2));
			}
			else {
				array_push($up, array_shift($rank1));
			}
		}
		while (count($rank2)) {
			array_push($up, array_shift($rank2));
		}
		for ($i = 0; $i < count($rank); $i++) {
			$result[2*$rank[$i]-2] = array_shift($up);
			$result[2*$rank[$i]-1] = array_shift($up);
		}
	}
	return $result;
}

function setPlayNo($account, $gameno, $content, $amount) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno'");
	while ($fetch = mysqli_fetch_array($sql)) {
		$position = playNoPosition($fetch['SYSTEMPLAYNO'], $amount);
		$content = str_replace('id="p'.$position.'">', 'id="p'.$position.'"><span style="float: right;">'.$fetch['PLAYNO'].'</span>', $content);
	}
	return $content;
}

function cycleSetPlayNo($account, $gameno, $content, $amount) {
	$mysql = $GLOBALS['mysql'];
	$distribute = distribute(getAmount($account, $gameno));
	$gap = 3 * (2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2']);
	$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno'");
	while ($fetch = mysqli_fetch_array($sql)) {
		if ($fetch['SYSTEMPLAYNO'] > $gap) {
			$position = playNoPosition($fetch['SYSTEMPLAYNO'] - $gap, $amount);
			$content = str_replace('id="p'.$position.'">', 'id="p'.$position.'"><span style="float: right;">'.$fetch['PLAYNO'].'</span>', $content);
		}
	}
	return $content;
}

function playNoPosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$adjust = 0;
	if ($playno == 2 * $bound) {
		$playno -= 1;
		$adjust = 1;
	}
	$layer = 1;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno * $times - $times / 2;
	if ($adjust == 1) {
		$layer += 1;
	}
	return $pos.'_'.$layer;
}

function setScoreInput($account, $gameno, $content, $amount) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno'");
	while ($fetch = mysqli_fetch_array($sql)) {
		$scoreInput = scoreInputPosition($fetch['SYSTEMPLAYNO'], $amount);
		if (!empty($fetch['PLAYNO'])) {
			$content = str_replace('id="p'.$scoreInput['above'].'">', 'id="p'.$scoreInput['above'].'"><input class="score" style="float: left;" type="text" id="'.$fetch['PLAYNO'].'_above">', $content);
			$content = str_replace('id="p'.$scoreInput['below'].'">', 'id="p'.$scoreInput['below'].'"><input class="score" style="float: left;" type="text" id="'.$fetch['PLAYNO'].'_below">', $content);
		}
	}
	return $content;
}

function cycleSetScoreInput($account, $gameno, $content, $amount) {
	$mysql = $GLOBALS['mysql'];
	$distribute = distribute(getAmount($account, $gameno));
	$gap = 3 * (2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2']);
	$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno'");
	while ($fetch = mysqli_fetch_array($sql)) {
		if ($fetch['SYSTEMPLAYNO'] > $gap) {
			$scoreInput = scoreInputPosition($fetch['SYSTEMPLAYNO'] - $gap, $amount);
			$content = str_replace('id="p'.$scoreInput['above'].'">', 'id="p'.$scoreInput['above'].'"><input class="score" style="float: left;" type="text" id="'.$fetch['PLAYNO'].'_above">', $content);
			$content = str_replace('id="p'.$scoreInput['below'].'">', 'id="p'.$scoreInput['below'].'"><input class="score" style="float: left;" type="text" id="'.$fetch['PLAYNO'].'_below">', $content);
		}
	}
	return $content;
}

function scoreInputPosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$adjust = 0;
	if ($playno == 2 * $bound) {
		$playno -= 1;
		$adjust = 1;
	}
	$layer = 2;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno*$times - $times/2;
	if ($adjust == 1) {
		$layer += 1;
	}
	$abovePos = $pos.'_'.$layer;
	$belowPos = ($pos+1).'_'.$layer;
	return array('above' => $abovePos, 'below' => $belowPos);
}

function getAmount($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT AMOUNT FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
	$fetch = mysqli_fetch_row($sql);
	return $fetch[0];
}

function getGametype($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT GAMETYPE FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
	$fetch = mysqli_fetch_row($sql);
	return $fetch[0];
}

function getPlaytype($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT PLAYTYPE FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
	$fetch = mysqli_fetch_row($sql);
	return $fetch[0];
}

function getGamename($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT GAMENM FROM GAMEMAIN WHERE USERNO='$account' AND GAMENO='$gameno'");
	$fetch = mysqli_fetch_row($sql);
	return $fetch[0];
}

function translatePlaytype($playtype) {
	if ($playtype == 'A') return "單打";
	elseif ($playtype == 'B') return "雙打";
	elseif ($playtype == 'C') return "團體";
}

function queryContentSingle($account, $gameno, $position) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT * FROM GAMEPOSITION WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$position'");
	$fetch = mysqli_fetch_array($sql);
	return array('unit' => $fetch['UNIT'], 'name' => $fetch['NAME']);
}

function queryContentDouble($account, $gameno, $position) {
	$mysql = $GLOBALS['mysql'];
	$sql1 = mysqli_query($mysql, "SELECT * FROM GAMEPOSITION WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$position' AND PLAYERNO=1");
	$fetch1 = mysqli_fetch_array($sql1);
	$sql2 = mysqli_query($mysql, "SELECT * FROM GAMEPOSITION WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$position' AND PLAYERNO=2");
	$fetch2 = mysqli_fetch_array($sql2);
	return array('unitu' => $fetch1['UNIT'], 'nameu' => $fetch1['NAME'], 'unitd' => $fetch2['UNIT'], 'named' => $fetch2['NAME']);
}

function queryContentGroup($account, $gameno, $position) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT * FROM GAMEPOSITION WHERE USERNO='$account' AND GAMENO='$gameno' AND POSITION='$position'");
	$fetch = mysqli_fetch_array($sql);
	return $fetch['UNIT'];
}

function queryState($account, $gameno, $playno) {
	$mysql = $GLOBALS['mysql'];
	$sql = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
	$fetch = mysqli_fetch_array($sql);
	return array('playno' => $fetch['PLAYNO'], 'above' => $fetch['ABOVE'], 'below' => $fetch['BELOW'], 'aboveScore' => $fetch['ABOVESCORE'], 'belowScore' => $fetch['BELOWSCORE'], 'winner' => $fetch['WINNER']);
}

function createGameState($account, $gameno, $amount) {
	$mysql = $GLOBALS['mysql'];
	for ($i = 1; $i <= $amount; $i++) {
		if ($i <= $amount/2) {
			mysqli_query($mysql, "INSERT INTO GAMESTATE (USERNO, GAMENO, SYSTEMPLAYNO, ABOVE, BELOW) VALUES ('$account', '$gameno', $i, $i*2-1, $i*2)");
		}
		else {
			mysqli_query($mysql, "INSERT INTO GAMESTATE (USERNO, GAMENO, SYSTEMPLAYNO) VALUES ('$account', '$gameno', $i)");
		}
	}
}

function updateAbovePosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$adjust = 0;
	if ($playno == 2 * $bound) {
		$playno -= 1;
		$adjust = 1;
	}
	$layer = 1;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno*$times - $times/2;
	if ($adjust == 1) {
		$layer += 1;
	}
	$temp = array();
	array_push($temp, $pos.'_'.$layer);
	$aboveLength = $times/4 - 1;
	for ($i = 1; $i <= $aboveLength; $i++) {
		array_push($temp, ($pos-$i).'_'.$layer);
	}
	return array('t-r' => array_pop($temp), 'r' => $temp);
}

function updateBelowPosition($playno, $amount) {
	$bound = pow(2, ceil(log($amount, 2))-1);
	$adjust = 0;
	if ($playno == 2 * $bound) {
		$playno -= 1;
		$adjust = 1;
	}
	$layer = 1;
	$times = 4;
	while ($playno > $bound) {
		$playno -= $bound;
		$bound /= 2;
		$times *= 2;
		$layer += 1;
	}
	$pos = $playno*$times - $times/2 + 1;
	if ($adjust == 1) {
		$layer += 1;
	}
	$temp = array();
	array_push($temp, $pos.'_'.$layer);
	$aboveLength = $times/4 - 1;
	for ($i = 1; $i <= $aboveLength; $i++) {
		array_push($temp, ($pos+$i).'_'.$layer);
	}
	return array('b-r' => array_pop($temp), 'r' => $temp);
}

function updateAbove($playno, $publicContent, $editContent, $amount) {
	$updateAbovePosition = updateAbovePosition($playno, $amount);
	$publicContent = str_replace('id="p'.$updateAbovePosition['t-r'].'"', 'class="t-r_red" id="p'.$updateAbovePosition['t-r'].'"', $publicContent);
	$editContent = str_replace('id="p'.$updateAbovePosition['t-r'].'"', 'class="t-r_red" id="p'.$updateAbovePosition['t-r'].'"', $editContent);
	while ($pos = array_pop($updateAbovePosition['r'])) {
		$publicContent = str_replace('id="p'.$pos.'"', 'class="r_red" id="p'.$pos.'"', $publicContent);
		$editContent = str_replace('id="p'.$pos.'"', 'class="r_red" id="p'.$pos.'"', $editContent);
	}
	return array('public' => $publicContent, 'edit' => $editContent);
}

function updateBelow($playno, $publicContent, $editContent, $amount) {
	$updateBelowPosition = updateBelowPosition($playno, $amount);
	$publicContent = str_replace('id="p'.$updateBelowPosition['b-r'].'"', 'class="b-r_red" id="p'.$updateBelowPosition['b-r'].'"', $publicContent);
	$editContent = str_replace('id="p'.$updateBelowPosition['b-r'].'"', 'class="b-r_red" id="p'.$updateBelowPosition['b-r'].'"', $editContent);
	while ($pos = array_pop($updateBelowPosition['r'])) {
		$publicContent = str_replace('id="p'.$pos.'"', 'class="r_red" id="p'.$pos.'"', $publicContent);
		$editContent = str_replace('id="p'.$pos.'"', 'class="r_red" id="p'.$pos.'"', $editContent);
	}
	return array('public' => $publicContent, 'edit' => $editContent);
}

function updateGameChart($account, $gameno) {
	$type = getGametype($account, $gameno);
	$amount = getAmount($account, $gameno);
	if ($type == 'A') {
		updateGameState($account, $gameno);
		$publicContent = publicContent($account, $gameno);
		$editContent = editContent($account, $gameno);
		$roundAmount = pow(2, ceil(log($amount, 2)));
		for ($i = 1; $i <= $roundAmount; $i++) {
			$state = queryState($account, $gameno, $i);
			if (is_numeric($state['aboveScore']) && is_numeric($state['belowScore'])) {
				$scoreInput = scoreInputPosition($i, $amount);
				$publicContent = str_replace('id="p'.$scoreInput['above'].'">', 'id="p'.$scoreInput['above'].'">'.$state['aboveScore'], $publicContent);
				$publicContent = str_replace('id="p'.$scoreInput['below'].'">', 'id="p'.$scoreInput['below'].'">'.$state['belowScore'], $publicContent);
				$editContent = str_replace('id="'.$state['playno'].'_above">', 'id="'.$state['playno'].'_above" value="'.$state['aboveScore'].'">', $editContent);
				$editContent = str_replace('id="'.$state['playno'].'_below">', 'id="'.$state['playno'].'_below" value="'.$state['belowScore'].'">', $editContent);
				if ($state['aboveScore'] > $state['belowScore']) {
					$return = updateAbove($i-$gap, $publicContent, $editContent, $roundAmount);
					$publicContent = $return['public'];
					$editContent = $return['edit'];
				}
				elseif ($state['aboveScore'] < $state['belowScore']) {
					$return = updateBelow($i-$gap, $publicContent, $editContent, $roundAmount);
					$publicContent = $return['public'];
					$editContent = $return['edit'];
				}
			}
		}
	}
	else {
		updateCycleGameState($account, $gameno);
		$publicContent = cyclePublicContent($account, $gameno);
		$editContent = cycleEditContent($account, $gameno);
		$distribute = distribute($amount);
		$roundAmount = $distribute['round'];
		$gap = 3 * ($distribute['3_1'] + $distribute['3_2']) + 6 * ($distribute['4_1'] + $distribute['4_2']);
		$total = $gap + $roundAmount;
		for ($i = 1; $i <= $total; $i++) {
			$state = queryState($account, $gameno, $i);
			if ($i <= $gap) {
				if (is_numeric($state['aboveScore']) && is_numeric($state['belowScore'])) {
					$publicContent = str_replace('id="'.$state['playno'].'_above">', 'id="'.$state['playno'].'_above">'.$state['aboveScore'], $publicContent);
					$publicContent = str_replace('id="'.$state['playno'].'_below">', 'id="'.$state['playno'].'_below">'.$state['belowScore'], $publicContent);
					$editContent = str_replace('id="'.$state['playno'].'_above">', 'id="'.$state['playno'].'_above" value="'.$state['aboveScore'].'">', $editContent);
					$editContent = str_replace('id="'.$state['playno'].'_below">', 'id="'.$state['playno'].'_below" value="'.$state['belowScore'].'">', $editContent);
				}
			}
			else {
				if (is_numeric($state['aboveScore']) && is_numeric($state['belowScore'])) {
					$scoreInput = scoreInputPosition($i-$gap, $roundAmount);
					$publicContent = str_replace('id="p'.$scoreInput['above'].'">', 'id="p'.$scoreInput['above'].'">'.$state['aboveScore'], $publicContent);
					$publicContent = str_replace('id="p'.$scoreInput['below'].'">', 'id="p'.$scoreInput['below'].'">'.$state['belowScore'], $publicContent);
					$editContent = str_replace('id="'.$state['playno'].'_above">', 'id="'.$state['playno'].'_above" value="'.$state['aboveScore'].'">', $editContent);
					$editContent = str_replace('id="'.$state['playno'].'_below">', 'id="'.$state['playno'].'_below" value="'.$state['belowScore'].'">', $editContent);
					if (strval($state['winner']) == "-1"){
						// Do nothing
					}
					elseif (strval($state['winner']) == strval($state['above'])) {
						$return = updateAbove($i-$gap, $publicContent, $editContent, $roundAmount);
						$publicContent = $return['public'];
						$editContent = $return['edit'];
					}
					elseif (strval($state['winner']) == strval($state['below'])) {
						$return = updateBelow($i-$gap, $publicContent, $editContent, $roundAmount);
						$publicContent = $return['public'];
						$editContent = $return['edit'];
					}
				}
			}
		}
	}
	unlink($account.'/'.$gameno."/public.html");
	unlink($account.'/'.$gameno."/edit.html");
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><link rel="stylesheet" type="text/css" href="resource/custom.css"><link rel="stylesheet" type="text/css" href="resource/tournament.css"></head><body>';
	$end = '</body><script src="resource/'.$roundAmount.'.js"></script></html>';
	$file = fopen($account.'/'.$gameno."/public.html", "w");
	fwrite($file, $start.$publicContent.$end);
	fclose($file);
	$file = fopen($account.'/'.$gameno."/edit.html", "w");
	fwrite($file, $start.$editContent.$end);
	fclose($file);
}

function updateGameState($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$amount = getAmount($account, $gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$start = 1;
	$next = 2;
	$middle = $roundAmount / 2 + 1;
	while ($middle < $roundAmount) {
		$sql1 = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		$fetch1 = mysqli_fetch_array($sql1);
		$sql2 = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		$fetch2 = mysqli_fetch_array($sql2);
		if ($fetch1['ABOVESCORE'] > $fetch1['BELOWSCORE']) {
			$above = $fetch1['ABOVE'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=ABOVE WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		}
		elseif ($fetch1['ABOVESCORE'] < $fetch1['BELOWSCORE']) {
			$above = $fetch1['BELOW'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=BELOW WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		}
		if ($fetch2['ABOVESCORE'] > $fetch2['BELOWSCORE']) {
			$below = $fetch2['ABOVE'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=ABOVE WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		}
		elseif ($fetch2['ABOVESCORE'] < $fetch2['BELOWSCORE']) {
			$below = $fetch2['BELOW'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=BELOW WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		}
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVE='$above', BELOW='$below' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$middle'");
		$start += 2;
		$next += 2;
		$middle += 1;
	}
}

// 0. Abstainee -> score -1; Ask for leave -> score 0
// 1. Update tournament for MS, MD, WS, WD, XD, Group
//    (1) winner -> 2, loser -> 1, abstainee -> remove from select list
//    (2) Check if there are 2 or more teams have same points.
//        (a) if 2 teams have same points -> compare their game results only
//        (b) if 3 teams have same points 
//        		MS,MD,WS,WD,XD	-> compare same points teams' game results only, (total points won ) - (total points lose)
//        		Group           -> compare same points teams' game results only, (total matches won) - (total matches lose)
//        (c) if still cannot decide, select by random number.
// 2. Push -1 to rank1 rank2 rank3, if "Bye".
function selectCycleSquarePlayer($account, $gameno, $game, $pos, $gap, $playtype, $num_select) {
	$game1 = queryState($account, $gameno, $game);
	$game2 = queryState($account, $gameno, $game+1);
	$game3 = queryState($account, $gameno, $gap + $game);
	$game4 = queryState($account, $gameno, $gap + $game+1);
	$game5 = queryState($account, $gameno, 2*$gap + $game);
	$game6 = queryState($account, $gameno, 2*$gap + $game+1);

	// Array to return
	$select_order = array();

	if (!empty($game1['winner']) && !empty($game2['winner']) && !empty($game3['winner']) && !empty($game4['winner']) && !empty($game5['winner']) && !empty($game6['winner'])) {
		// Array to help calculate priority
		$priority = array(0, 0, 0, 0);

		// (1-1) Remove abstainee from list, set priority[$i] = -1.
		if ($game1['aboveScore'] == -1 || $game3['aboveScore'] == -1 || $game5['aboveScore'] == -1) $priority[0] = -1;
		if ($game1['belowScore'] == -1 || $game4['aboveScore'] == -1 || $game6['aboveScore'] == -1) $priority[1] = -1;
		if ($game3['belowScore'] == -1 || $game2['aboveScore'] == -1 || $game6['belowScore'] == -1) $priority[2] = -1;
		if ($game2['belowScore'] == -1 || $game4['belowScore'] == -1 || $game5['belowScore'] == -1) $priority[3] = -1;
		
		// Return directly, if has result.
		$max_pos = array_keys($priority, max($priority));
		if (max($priority) == -1){
			for ($num = 1; $num <= $num_select; $num++){
				array_push($select_order, -1);
			}
			return $select_order;
		}
		if (count($max_pos) == 1) {
			array_push($select_order, array_pop($max_pos) + $pos);
			if ($num_select == 2){
				array_push($select_order, -1);
			}
			return $select_order;
		}

		// (1-2) Calculate priority for players whose priority != -1, and only games without abstainee are included.
		for ($i = 0; $i < count($priority); $i++){
			// Skip if encounter abstainee
			if ($priority[$i] == -1) continue;

			for ($j = $i; $j < count($priority); $j++){
				// Skip if encounter myself or abstainee
				if ($i == $j || $priority[$j] == -1) continue;

				// Calculate priority only,
				// since we don't know who has the same priority yet, that needs further consideration.
				if ($i == 0 && $j == 1){
					if ($game1['winner'] == $game1['above']) {
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
				}
				elseif ($i == 0 && $j == 2){
					if ($game3['winner'] == $game3['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
				}
				elseif ($i == 0 && $j == 3){
					if ($game5['winner'] == $game5['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
				}
				elseif ($i == 1 && $j == 2){
					if ($game6['winner'] == $game6['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
				}
				elseif ($i == 1 && $j == 3){
					if ($game4['winner'] == $game4['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
				}
				elseif ($i == 2 && $j == 3){
					if ($game2['winner'] == $game2['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
				}
			}
		}

		// (2) Select player
		while($num_select > 0){
			// Select through $priority
			$max_pos = array_keys($priority, max($priority));

			// (2-1) Only 1 selected
			if (count($max_pos) == 1){
				
				$select_pos = array_pop($max_pos);
				
				array_push($select_order, $pos + $select_pos);
				$num_select = $num_select - 1;
				$priority[$select_pos] = -1;
				continue;
			}
			// (2-2) Two are selected
			elseif (count($max_pos) == 2){
				// Make $j > $i
				$j = array_pop($max_pos);
				$i = array_pop($max_pos);

				if ($i == 0 && $j == 1){
					if ($game1['winner'] == $game1['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 0 && $j == 2){
					if ($game3['winner'] == $game3['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 0 && $j == 3){
					if ($game5['winner'] == $game5['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 1 && $j == 2){
					if ($game6['winner'] == $game6['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 1 && $j == 3){
					if ($game4['winner'] == $game4['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 2 && $j == 3){
					if ($game2['winner'] == $game2['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				
				array_push($select_order, $pos + $select_pos);
				$num_select = $num_select - 1;
				$priority[$select_pos] = -1;
				continue;
			}
			// (2-3) Three or more are selected
			elseif (count($max_pos) >= 3 && max($priority) != -1){
				// (b) if 3 teams have same priority -> compare same $priority points teams' game results only, 
				//     GP ($playtype='C') -> $score = (total matches won) - (total matches lose)
				//     MS,MD,WS,WD,XD     -> $score = (total points won) - (total points lose)
				
				// Find related teams score
				$score = array(0,0,0,0);

				// Calculate related teams score
				for ($index1 = 0; $index1 < count($max_pos); $index1++){
					for ($index2 = $index1+1; $index2 < count($max_pos); $index2++){
						// Make $j > $i , and $i, $j are in $max_pos
						$i = $max_pos[$index1];
						$j = $max_pos[$index2];

						// Calculate related score
						if ($i == 0 && $j == 1){
							if ($playtype == 'C'){
								$score[$i] = $score[$i] + intdiv($game1['aboveScore'], 1000) - intdiv($game1['belowScore'], 1000);
								$score[$j] = $score[$j] + intdiv($game1['belowScore'], 1000) - intdiv($game1['aboveScore'], 1000);
							}
							else{
								$score[$i] = $score[$i] + $game1['aboveScore'] - $game1['belowScore'];
								$score[$j] = $score[$j] + $game1['belowScore'] - $game1['aboveScore'];
							}
						}
						elseif ($i == 0 && $j == 2){
							if ($playtype == 'C'){
								$score[$i] = $score[$i] + intdiv($game3['aboveScore'], 1000) - intdiv($game3['belowScore'], 1000);
								$score[$j] = $score[$j] + intdiv($game3['belowScore'], 1000) - intdiv($game3['aboveScore'], 1000);
							}
							else{
								$score[$i] = $score[$i] + $game3['aboveScore'] - $game3['belowScore'];
								$score[$j] = $score[$j] + $game3['belowScore'] - $game3['aboveScore'];
							}
						}
						elseif ($i == 0 && $j == 3){
							if ($playtype == 'C'){
								$score[$i] = $score[$i] + intdiv($game5['aboveScore'], 1000) - intdiv($game5['belowScore'], 1000);
								$score[$j] = $score[$j] + intdiv($game5['belowScore'], 1000) - intdiv($game5['aboveScore'], 1000);
							}
							else{
								$score[$i] = $score[$i] + $game5['aboveScore'] - $game5['belowScore'];
								$score[$j] = $score[$j] + $game5['belowScore'] - $game5['aboveScore'];
							}
						}
						elseif ($i == 1 && $j == 2){
							if ($playtype == 'C'){
								$score[$i] = $score[$i] + intdiv($game6['aboveScore'], 1000) - intdiv($game6['belowScore'], 1000);
								$score[$j] = $score[$j] + intdiv($game6['belowScore'], 1000) - intdiv($game6['aboveScore'], 1000);
							}
							else{
								$score[$i] = $score[$i] + $game6['aboveScore'] - $game6['belowScore'];
								$score[$j] = $score[$j] + $game6['belowScore'] - $game6['aboveScore'];
							}
						}
						elseif ($i == 1 && $j == 3){
							if ($playtype == 'C'){
								$score[$i] = $score[$i] + intdiv($game4['aboveScore'], 1000) - intdiv($game4['belowScore'], 1000);
								$score[$j] = $score[$j] + intdiv($game4['belowScore'], 1000) - intdiv($game4['aboveScore'], 1000);
							}
							else{
								$score[$i] = $score[$i] + $game4['aboveScore'] - $game4['belowScore'];
								$score[$j] = $score[$j] + $game4['belowScore'] - $game4['aboveScore'];
							}
						}
						elseif ($i == 2 && $j == 3){
							if ($playtype == 'C'){
								$score[$i] = $score[$i] + intdiv($game2['aboveScore'], 1000) - intdiv($game2['belowScore'], 1000);
								$score[$j] = $score[$j] + intdiv($game2['belowScore'], 1000) - intdiv($game2['aboveScore'], 1000);
							}
							else{
								$score[$i] = $score[$i] + $game2['aboveScore'] - $game2['belowScore'];
								$score[$j] = $score[$j] + $game2['belowScore'] - $game2['aboveScore'];
							}
						}
					}
				}

				// Pick each related team's score
				$max_pos_score = array();
				for ($i = 0; $i < count($max_pos); $i++){
					array_push($max_pos_score, $score[$max_pos[$i]]);
				}

				// Select player, until all of them are chosen or no more $num_select 
				while(max($max_pos_score) != -3000 && $num_select > 0){

					// Select through related team score
					$max_pos_score_index = array_keys($max_pos_score, max($max_pos_score));

					if (count($max_pos_score_index) == 1){
						$select_pos = $max_pos[array_pop($max_pos_score_index)];
					}
					else{
						// (c) if still cannot decide, select by random number.
						srand($pos + $gap + $num_select);
						$select_pos = $max_pos[$max_pos_score_index[rand() % count($max_pos_score_index)]];
					}

					array_push($select_order, $pos + $select_pos);
					$num_select = $num_select - 1;
					$priority[$select_pos] = -1;
					$max_pos_score[array_search($select_pos, $max_pos)] = -3000;
				}
				continue;
			}
			else{
				break;
			}
		}

		return $select_order;
	}
	else{
		for ($num = 1; $num <= $num_select; $num++){
			array_push($select_order, NULL);
		}
		return $select_order;
	}
}

function selectCycleTrianglePlayer($account, $gameno, $game, $pos, $gap, $playtype, $num_select) {
	$game1 = queryState($account, $gameno, $game);
	$game2 = queryState($account, $gameno, $gap + $game);
	$game3 = queryState($account, $gameno, 2*$gap + $game);

	// Array to return
	$select_order = array();

	if (!empty($game1['winner']) && !empty($game2['winner']) && !empty($game3['winner'])) {
		// Array to help calculate priority
		$priority = array(0, 0, 0);
		$score = array(0, 0, 0);

		// (1-1) Remove abstainee from list, set priority[$i] = -1.
		if ($game1['aboveScore'] == -1 || $game2['aboveScore'] == -1) $priority[0] = -1;
		if ($game1['belowScore'] == -1 || $game3['aboveScore'] == -1) $priority[1] = -1;
		if ($game2['belowScore'] == -1 || $game3['belowScore'] == -1) $priority[2] = -1;

		// Return directly, if has result.
		$max_pos = array_keys($priority, max($priority));
		if (max($priority) == -1){
			for ($num = 1; $num <= $num_select; $num++){
				array_push($select_order, -1);
			}
			return $select_order;
		}
		if (count($max_pos) == 1) {
			array_push($select_order, array_pop($max_pos) + $pos);
			if ($num_select == 2){
				array_push($select_order, -1);
			}
			return $select_order;
		}

		// (1-2) Calculate priority for players whose priority != -1, and only games without abstainee are included.
		for ($i = 0; $i < count($priority); $i++){
			// Skip if encounter abstainee, and set their score to -3000
			if ($priority[$i] == -1){
				$score[$i] = -3000;
				continue;
			}

			// Calculate points
			for ($j = $i; $j < count($priority); $j++){
				// Skip if encounter myself or abstainee
				if ($i == $j || $priority[$j] == -1) continue;

				// Calculate priority and score.
				// We can calculate score first, since only when all are considered, we will be using it.
				//     GP ($playtype='C') -> $score = (total matches won) - (total matches lose)
				//     MS,MD,WS,WD,XD     -> $score = (total points won) - (total points lose)
				if ($i == 0 && $j == 1){
					if ($game1['winner'] == $game1['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
					if ($playtype == 'C'){
						$score[$i] = $score[$i] + intdiv($game1['aboveScore'], 1000) - intdiv($game1['belowScore'], 1000);
						$score[$j] = $score[$j] + intdiv($game1['belowScore'], 1000) - intdiv($game1['aboveScore'], 1000);
					}
					else{
						$score[$i] = $score[$i] + $game1['aboveScore'] - $game1['belowScore'];
						$score[$j] = $score[$j] + $game1['belowScore'] - $game1['aboveScore'];
					}
				}
				elseif ($i == 0 && $j == 2){
					if ($game2['winner'] == $game2['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
					if ($playtype == 'C'){
						$score[$i] = $score[$i] + intdiv($game2['aboveScore'], 1000) - intdiv($game2['belowScore'], 1000);
						$score[$j] = $score[$j] + intdiv($game2['belowScore'], 1000) - intdiv($game2['aboveScore'], 1000);
					}
					else{
						$score[$i] = $score[$i] + $game2['aboveScore'] - $game2['belowScore'];
						$score[$j] = $score[$j] + $game2['belowScore'] - $game2['aboveScore'];
					}
				}
				elseif ($i == 1 && $j == 2){
					if ($game3['winner'] == $game3['above']){
						$priority[$i] = $priority[$i] + 2;
						$priority[$j] = $priority[$j] + 1;
					}
					else{
						$priority[$j] = $priority[$j] + 2;
						$priority[$i] = $priority[$i] + 1;
					}
					if ($playtype == 'C'){
						$score[$i] = $score[$i] + intdiv($game3['aboveScore'], 1000) - intdiv($game3['belowScore'], 1000);
						$score[$j] = $score[$j] + intdiv($game3['belowScore'], 1000) - intdiv($game3['aboveScore'], 1000);
					}
					else{
						$score[$i] = $score[$i] + $game3['aboveScore'] - $game3['belowScore'];
						$score[$j] = $score[$j] + $game3['belowScore'] - $game3['aboveScore'];
					}
				}
			}
		}

		// (2) Select Player
		while($num_select > 0){
			// Select through $priority
			$max_pos = array_keys($priority, max($priority));

			// (2-1) Only 1 selected
			if (count($max_pos) == 1){

				$select_pos = array_pop($max_pos);

				array_push($select_order, $pos + $select_pos);
				$num_select = $num_select - 1;
				$priority[$select_pos] = -1;
				$score[$select_pos] = -3000;
				continue;
			}
			// (2-2) Two are selected, compare their game result only
			elseif (count($max_pos) == 2){
				// Make $j > $i
				$j = array_pop($max_pos);
				$i = array_pop($max_pos);

				if ($i == 0 && $j == 1){
					if ($game1['winner'] == $game1['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 0 && $j == 2){
					if ($game2['winner'] == $game2['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				elseif ($i == 1 && $j == 2){
					if ($game3['winner'] == $game3['above']) $select_pos = $i;
					else $select_pos = $j;
				}
				array_push($select_order, $pos + $select_pos);
				$num_select = $num_select - 1;
				$priority[$select_pos] = -1;
				$score[$select_pos] = -3000;
				continue;
			}
			// (2-3) Three are selected
			elseif (count($max_pos) == 3 && max($priority) != -1){
				// (b) if 3 teams have same $priority points -> compare their game results only
				$max_pos_score = array(0, 0, 0);
				for ($i = 0; $i < 3; $i++){
					$max_pos_score[$i] = $score[$max_pos[$i]];
				}
				
				// Select player, until all of them are chosen or no more $num_select
				while(max($max_pos_score) != -3000 && $num_select > 0){
					$max_pos_score_index = array_keys($max_pos_score, max($max_pos_score));

					if(count($max_pos_score_index) == 1){
						$select_pos = $max_pos[array_pop($max_pos_score_index)];
					}
					else{
						// (c) if still cannot decide, select by random number.
						srand($pos + $gap + $num_select);
						$select_pos = $max_pos[$max_pos_score_index[rand() % count($max_pos_score_index)]];
					}
					array_push($select_order, $pos + $select_pos);
					$num_select = $num_select - 1;
					$priority[$select_pos] = -1;
					$max_pos_score[array_search($select_pos, $max_pos)] = -3000;
				}
				continue;
			}
			else{
				break;
			}
		}

		return $select_order;
	}
	else{
		for ($num = 1; $num <= $num_select; $num++){
			array_push($select_order, NULL);
		}
		return $select_order;
	}
}

function updateCycleGameState($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$amount = getAmount($account, $gameno);
	$playtype = getPlaytype($account, $gameno);
	$distribute = distribute($amount);
	$gap = 2 * ($distribute['4_1'] + $distribute['4_2']) + $distribute['3_1'] + $distribute['3_2'];
	$game = 1;
	$pos = 1;
	$rank1 = array();
	$rank2 = array();
	$rank3 = array();
	for ($cycle = 1; $cycle <= $distribute['4_2']; $cycle++) {
		$select_order = selectCycleSquarePlayer($account, $gameno, $game, $pos, $gap, $playtype, 2);
		array_push($rank1, array_shift($select_order));
		array_push($rank3, array_shift($select_order));
		$game += 2;
		$pos += 4;
	}
	for ($cycle = 1; $cycle <= $distribute['4_1']; $cycle++) {
		$select_order = selectCycleSquarePlayer($account, $gameno, $game, $pos, $gap, $playtype, 1);	
		array_push($rank1, array_shift($select_order));
		$game += 2;
		$pos += 4;
	}
	for ($cycle = 1; $cycle <= $distribute['3_1']; $cycle++) {
		$select_order = selectCycleTrianglePlayer($account, $gameno, $game, $pos, $gap, $playtype, 1);
		array_push($rank2, array_shift($select_order));
		$game++;
		$pos += 3;
	}
	for ($cycle = 1; $cycle <= $distribute['3_2']; $cycle++) {
		$select_order = selectCycleTrianglePlayer($account, $gameno, $game, $pos, $gap, $playtype, 2);
		array_push($rank2, array_shift($select_order));
		array_push($rank3, array_shift($select_order));
		$game++;
		$pos += 3;
	}
	$up = arrange($rank1, $rank2, $rank3);
	for ($i = 2; $i <= $distribute['round']; $i+=2) {
		$playno = 3*$gap + $i/2;
		$above = array_pop($up);
		$below = array_pop($up);
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVE='$above' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
		mysqli_query($mysql, "UPDATE GAMESTATE SET BELOW='$below' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
	}
	$roundAmount = 3*$gap + $distribute['round'];
	$start = 3*$gap + 1;
	$next = 3*$gap + 2;
	$middle = 3*$gap + $distribute['round'] / 2 + 1;
	while ($middle < $roundAmount) {
		$sql1 = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		$fetch1 = mysqli_fetch_array($sql1);
		$sql2 = mysqli_query($mysql, "SELECT * FROM GAMESTATE WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		$fetch2 = mysqli_fetch_array($sql2);
		if ($fetch1['ABOVESCORE'] > $fetch1['BELOWSCORE']) {
			$above = $fetch1['ABOVE'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=ABOVE WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		}
		elseif ($fetch1['ABOVESCORE'] < $fetch1['BELOWSCORE']) {
			$above = $fetch1['BELOW'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=BELOW WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$start'");
		}
		if ($fetch2['ABOVESCORE'] > $fetch2['BELOWSCORE']) {
			$below = $fetch2['ABOVE'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=ABOVE WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		}
		elseif ($fetch2['ABOVESCORE'] < $fetch2['BELOWSCORE']) {
			$below = $fetch2['BELOW'];
			mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER=BELOW WHERE GAMENO='$gameno' AND SYSTEMPLAYNO='$next'");
		}
		mysqli_query($mysql, "UPDATE GAMESTATE SET ABOVE='$above', BELOW='$below' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$middle'");
		$start += 2;
		$next += 2;
		$middle += 1;
	}
}

function clearBye($account, $gameno) {
	$mysql = $GLOBALS['mysql'];
	$amount = getAmount($account, $gameno);
	$playtype = getPlaytype($account, $gameno);
	$roundAmount = pow(2, ceil(log($amount, 2)));
	$single = 1;
	$double = 2;
	$playno = 1;
	while ($single < $roundAmount) {
		if ($playtype == 'A') {
			$querySingle = queryContentSingle($account, $gameno, $single);
			$queryDouble = queryContentSingle($account, $gameno, $double);
			if ($querySingle['unit'] == 'none') {
				mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER='$double' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
			}
			elseif ($queryDouble['unit'] == 'none') {
				mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER='$single' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
			}
		}
		elseif ($playtype == 'B') {
			$querySingle = queryContentDouble($account, $gameno, $single);
			$queryDouble = queryContentDouble($account, $gameno, $double);
			if ($querySingle['unitu'] == 'none') {
				mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER='$double' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
			}
			elseif ($queryDouble['unitu'] == 'none') {
				mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER='$single' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
			}
		}
		elseif ($playtype == 'C') {
			$querySingle = queryContentGroup($account, $gameno, $single);
			$queryDouble = queryContentGroup($account, $gameno, $double);
			if ($querySingle == 'none') {
				mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER='$double' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
			}
			elseif ($queryDouble == 'none') {
				mysqli_query($mysql, "UPDATE GAMESTATE SET WINNER='$single' WHERE USERNO='$account' AND GAMENO='$gameno' AND SYSTEMPLAYNO='$playno'");
			}
		}
		$single += 2;
		$double += 2;
		$playno++;
	}
}

function makeGame($account, $gameno) {
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><script src="resource/custom.js"></script></head><body>';
	$content = '<p id="gameState"></p>';
	$end = '</body><script>updateGame(\''.$account.'\', \''.$gameno.'\')</script></html>';
	$file = fopen($account.'/'.$gameno."/game.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
	$start = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>電子化賽程系統</title><script src="resource/custom.js"></script></head><body>';
	$content = '<p id="gameState"></p>';
	$end = '</body><button onclick="location.assign(\'resource/output.php?account='.$account.'&gameno='.$gameno.'\')">輸出主審單</button><script>updateFunction(\''.$account.'\', \''.$gameno.'\')</script></html>';
	$file = fopen($account.'/'.$gameno."/function.html", "w");
	fwrite($file, $start.$content.$end);
	fclose($file);
}

function distribute($amount) {
	$small = $amount/4;
	$big = $amount/3;
	$temp_a = 0;
	$temp_b = 0;
	$temp_r = 0;
	$temp_m = 0;
	$_3_1 = 0;
	$_3_2 = 0;
	$_4_1 = 0;
	$_4_2 = 0;
	$temp_diff = 999;
	for ($i = ceil($small); $i <= $big; $i++) {
		$m = pow(2, ceil(log($i, 2)));
		$b = $m - $i;
		$a = $m - 2 * $b;
		$r = $amount - 3 * $a - 3 * $b;
		$diff = abs($b - $r);
		if ($b == 0) {
			$temp_a = $a;
			$temp_b = $b;
			$temp_r = $r;
			$temp_m = $m;
			break;
		}
		elseif ($diff < $temp_diff) {
			$temp_diff = $diff;
			$temp_a = $a;
			$temp_b = $b;
			$temp_r = $r;
			$temp_m = $m;
		}
	}

	if ($temp_r > $temp_b) {
		$_3_1 = $temp_a + $temp_b - $temp_r;
		$_3_2 = 0;
		$_4_1 = $temp_r - $temp_b;
		$_4_2 = $temp_b;
	}
	else {
		$_3_1 = $temp_a;
		$_3_2 = $temp_b - $temp_r;
		$_4_1 = 0;
		$_4_2 = $temp_r;
	}
	return array('3_1' => $_3_1, '3_2' => $_3_2, '4_1' => $_4_1, '4_2' => $_4_2, 'round' => $temp_m);
}

function login($account, $password) {
	$mysql = $GLOBALS['mysql'];
	$sql1 = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch1 = mysqli_fetch_array($sql1);
	if (empty($account)) {
		return '請輸入帳號';
	}
	elseif (empty($password)) {
		return '請輸入密碼';
	}
	elseif (mysqli_num_rows($sql1) == 0) {
		return '未註冊的帳號';
	}
	elseif ($password != $fetch1['PASSWORD']) {
		return '密碼錯誤';
	}
	elseif ($fetch1['OCCUPY'] == 1) {
		return '賽程製作中，暫時無法進入';
	}
	else {
		$token = get_token();
		$sql2 = "UPDATE USERMAS SET TOKEN='$token' WHERE USERNO='$account'";
		if (mysqli_query($mysql, $sql2)) {
			return array('message' => 'Success', 'token' => $token);
		}
		else {
			return '資料庫錯誤';
		}
	}
}

function logon($account, $password) {
	$mysql = $GLOBALS['mysql'];
	$sql1 = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch1 = mysqli_fetch_array($sql1);
	if (empty($account)) {
		return '請輸入帳號';
	}
	elseif (empty($password)) {
		return '請輸入密碼';
	}
	elseif (mysqli_num_rows($sql1) != 0) {
		return '此帳號已被註冊';
	}
	else {
		date_default_timezone_set('Asia/Taipei');
		$date = date("Y-m-d H:i:s");
		$token = get_token();
		$sql2 = "INSERT INTO USERMAS (USERNO, TOKEN, PASSWORD, CREATEDATE, LOGINDATE, AUTHDATE) VALUES ('$account', '$token', '$password', '$date', '$date', '$date')";
		if (mysqli_query($mysql, $sql2)) {
			return array('message' => 'Success', 'token' => $token);
		}
		else {
			return '資料庫錯誤';
		}
	}
}

function logout($account) {
	$mysql = $GLOBALS['mysql'];
	$sql1 = mysqli_query($mysql, "SELECT * FROM USERMAS WHERE USERNO='$account'");
	$fetch1 = mysqli_fetch_array($sql1);
	if (empty($account)) {
		return '請輸入帳號';
	}
	elseif (mysqli_num_rows($sql1) == 0) {
		return '未註冊的帳號';
	}
	else {
		$sql2 = "UPDATE USERMAS SET TOKEN='' WHERE USERNO='$account'";
		if (mysqli_query($mysql, $sql2)) {
			return 'Success';
		}
		else {
			return '資料庫錯誤';
		}
	}
}

function get_token() {
	$str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$code = '';
	for ($i = 0; $i < 12; $i++) {
		$code .= $str[mt_rand(0, strlen($str)-1)];
	}
	return $code;
}