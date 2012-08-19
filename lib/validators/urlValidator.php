<?php
/**
 * Validators
 * v 1.0.0
 */
class UrlValidator
{
	public static $message = "Неправильный URL сайта. URL должен начинаться с http и может содержать русские буквы, параметры и якорь.";

	public static function isUrl( $value )
	{
		if (!is_string($value))
			return false;

		$value = trim($value);
		$r = LinkHelper::detectUrl($value, false);

		// Если ничего не найдено или найдено, но не совпадает с оригиналом (т.е. что-то было обрезано), то это ошибка
		if (count($r[0]) == 0 || $r[0][0] != $value)
			return false;

		return $value;
	}
}
