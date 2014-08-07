<?php

# Error Reporting on
error_reporting(E_ALL);       # Report Errors, Warnings, and Notices
ini_set('display_errors', 1); # Display errors on page (instead of a log file)

# Load dependencies
require 'vendor\autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

# Main scraping logics
function scrape_pokemon($base_URL, $url) {
	# create HTML DOM
	$html = HtmlDomParser::file_get_html( $url );
	
	$ret = array();
	$i = 1;
	# Iterate through pages storing pokemon data
	foreach($html->find('table.data-table tbody tr') as $row) {
		# Grab pokemon name
		$a = $row->find('a.ent-name', 0);
		if ($a != NULL) {
			$name = $a->innertext;
			# Ignore repeat names (mega-evolutions list pokemon mulitple times)
			if(end($ret)['name'] != $name) {

				# Recurse to specific pokemon page
				$html2 = HtmlDomParser::file_get_html($base_URL . $a->href);
				$basics = $html2->find('div[class=tabset-basics]', 0);
				$image = $basics->find('img', 0)->src;
				$vitals_table = $basics->find('table.vitals-table', 0);

				# Initialize variables
				$type = array();
				$ability = array();

				# Iterate through vitals table grabbing key information
				foreach ($vitals_table->find('tr') as $row) {
					$innertext = $row->find('th', 0)->innertext;
					# Look for pokemon type, weight, height, and abilities
					switch ($innertext) {
						case 'Type':
							foreach ($row->find('a') as $a_type)
								array_push($type, $a_type->innertext);
							break;
						case 'Weight':
							$weight = $row->find('td', 0)->innertext;
							break;
						case 'Height':
							$height = $row->find('td', 0)->innertext;
							break;
						case 'Abilities':
							foreach ($row->find('a') as $a_ability)
								array_push($ability, $a_ability->innertext);
							break; 
					}
				}

				# Iterate through all the moves learned via level-up
				$moves = array();
				$moves_table = $html2->find('div[class=col desk-span-6 lap-span-12] table[class=data-table wide-table]', 0);
				foreach	($moves_table->find('tbody tr') as $row) {
					if ($row != NULL) {
						if ($row->find('td.num', 0) != NULL) {
							$level = $row->find('td.num', 0)->innertext;
							$move_name = $row->find('a.ent-name', 0)->innertext;
							$move = array('level' => $level, 'move_name' => $move_name);
							array_push($moves, $move);
						}
					}
				}

				# Instantiate this pokemon
				$pokemon = array(
					'name' 		=> $a->innertext,
					'index' 	=> $i,
					'image' 	=> $image,
					'URI' 		=> str_replace("/pokedex/", "", $a->href),
					'height' 	=> $height,
					'weight' 	=> $weight,
					'type' 		=> $type,
					'ability' => $ability,
					'moves' 	=> $moves
				);
				array_push($ret, $pokemon);

				# Clean up
				$html2->clear();
				unset($html2);

				# Give server time before next request
				if ($i % 10 == 0) {
					echo "sleeping...";
					sleep(5);
					echo "I'm awake!" . PHP_EOL;
				}
				$i += 1;
			}
		}
	}

	// clean up memory
	$html->clear();
	unset($html);

	return $ret;
}

# Main scraping logic for moves
function scrape_moves($base_URL, $url) {
	# Create new HTML Dom element and result array
	$html = HtmlDomParser::file_get_html( $url );
	$result = array();

	# Iterate through all moves on page
	$i = 0;
	foreach ($html->find('table.data-table tbody tr') as $row) {
		# Grab move  name
		$a = $row->find('a.ent-name', 0);
		if ($a != NULL) {
			$name = $a->innertext;

			# Recurse to the move's detailed page
			$html2 = HtmlDomParser::file_get_html($base_URL . $a->href);
			$vitals_table = $html2->find('table.vitals-table', 0);
			foreach ($vitals_table->find('tr') as $row) {
				$heading = $row->find('th', 0)->innertext;
				# Grab key info for a move
				switch ($heading) {
					case 'Type':
						$type = $row->find('a', 0)->innertext;
						break;
					case 'Category':
						$category = $row->find('i.icon-move-cat', 0)->innertext;
						break;
					case 'Power':
						$power = $row->find('td', 0)->innertext;
						break;
					case 'Accuracy':
						$accuracy = $row->find('td', 0)->innertext;
						break;
					case 'PP':
						$pp = $row->find('td', 0)->innertext;
						break;
				}
			}
			# Get effect and target description of move
			$effect_element = $html2->find('div[class=col desk-span-9 lap-span-8]', 0);
			$effect = $effect_element->find('p', 0)->innertext;
			$target_element = $html2->find('div[class=col desk-span-4 lap-span-12]', 0);
			$target = $target_element->find('p', 0)->innertext;

			# Push results into return array
			$move = array(
				'name' => $name,
				'type' => $type,
				'category' => $category,
				'power' => $power,
				'accuracy' => $accuracy,
				'PP' => $pp,
				'effect' => $effect,
				'target' => $target,
			);
			array_push($result, $move);

			# Clean-up
			$html2->clear();
			unset($html2);
			# Give server time before next request
			if ($i % 10 == 0) {
				echo "sleeping...";
				sleep(5);
				echo "I'm awake!" . PHP_EOL;
			}
			$i += 1;
		}
	}
	$html->clear();
	unset($html);
	return $result;
}

# Main scraping logic for abilities
function scrape_abilities($url) {

	# Create HTML Dom element and result array
	$html = HtmlDomParser::file_get_html( $url );
	$result = array();

	$i = 0;
	# Iterate through each ability and collect name and effect
	foreach ($html->find('table.psypoke tbody tr') as $row) {
			$match = false;
			foreach ($row->find('td[!class]') as $cell) {
				if ($cell->find('a[name]', 0)) {
					$name = $cell->plaintext;
					$match = true;
				}
				elseif (!$cell->find('a', 0)) {
					$effect = $cell->plaintext;
					$match = true;
				}
			}
		if ($match) {
			$ability = array(
				'name' => $name,
				'effect' => $effect
			);
			array_push($result, $ability);
		}
	}

	# Clean up
	$html->clear();
	unset($html);
	return $result;
}

$base_URL = 'http://pokemondb.net';

# Scrape for moves and save data in 'moves.json' file
$moves = scrape_moves($base_URL, $base_URL . '/move/all' );
file_put_contents('moves.json', json_encode($moves));

# Scrape for abilities and save data in 'abilities.json' file
$abilities = scrape_abilities('http://www.psypokes.com/lab/abilities.php'); // this URL better for abilities
file_put_contents('abilities.json', json_encode($abilities));

# Scrape for pokemon and save data in 'pokemon.json' file
$pokemon = scrape_pokemon($base_URL, $base_URL . '/pokedex/all');
file_put_contents('pokemon.json', json_encode($pokemon));
