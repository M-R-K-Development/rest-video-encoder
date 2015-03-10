<?php namespace Rve\Services;

/**
 * General purpose sanitize helper
 */
class Helpers {
	public static function sanitizeString($string = null) {
		if (empty($string)) {
			throw new \InvalidArgumentException('No input string is given');
		}
		$string = strip_tags($string);
		// Preserve escaped octets.
		$string = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $string);
		// Remove percent signs that are not part of an octet.
		$string = str_replace('%20', '', $string);
		$string = str_replace('%', '', $string);

		if (function_exists('mb_strtolower')) {
			$string = mb_strtolower($string, 'UTF-8');
		} else {
			$string = strtolower($string);
		}
		$string = preg_replace('/\p{Mn}/u', '', \Normalizer::normalize($string, \Normalizer::FORM_KD));
		$string = preg_replace('/[^%a-z0-9 _-]/', '', $string);
		$string = preg_replace('/\s+/', '-', $string);
		$string = preg_replace('|-+|', '-', $string);
		$string = trim($string, '-');

		return $string;
	}
}
