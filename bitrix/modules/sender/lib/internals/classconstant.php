<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sender
 * @copyright 2001-2012 Bitrix
 */
namespace Bitrix\Sender\Internals;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Class Type
 * @package Bitrix\Sender\Internals
 */
class ClassConstant
{
	/**
	 * Get caption.
	 *
	 * @param integer $id ID.
	 * @return integer|null
	 */
	public static function getName($id)
	{
		return static::getCode($id);
	}

	/**
	 * Get class constants.
	 *
	 * @return array
	 */
	protected static function getConstants()
	{
		static $constants = null;
		if ($constants === null)
		{
			$class = new \ReflectionClass(get_called_class());
			$constants = $class->getConstants();
		}

		return $constants;
	}

	/**
	 * Get list.
	 *
	 * @return array
	 */
	public static function getList()
	{
		$result = array();
		$constants = static::getConstants();
		foreach ($constants as $code => $id)
		{
			$result[] = $id;
		}
		return $result;
	}

	/**
	 * Get codes.
	 *
	 * @return array
	 */
	public static function getCodes()
	{
		$result = array();
		$constants = static::getConstants();
		foreach ($constants as $code => $id)
		{
			$result[] = $code;
		}
		return $result;
	}

	/**
	 * Get named list.
	 *
	 * @return array
	 */
	public static function getNamedList()
	{
		$result = array();
		$constants = static::getConstants();
		foreach ($constants as $code => $id)
		{
			$result[$id] = static::getName($id);
		}
		return $result;
	}

	/**
	 * Get named list.
	 *
	 * @return array
	 */
	public static function getNamedCodes()
	{
		$result = array();
		$constants = static::getConstants();
		foreach ($constants as $code => $id)
		{
			$result[$code] = static::getName($id);
		}
		return $result;
	}

	/**
	 * Get ID.
	 *
	 * @param string $code Code.
	 * @return integer|null
	 */
	public static function getId($code)
	{
		$constants = static::getConstants();
		return isset($constants[$code]) ? $constants[$code] : null;
	}

	/**
	 * Get code.
	 *
	 * @param integer $id ID.
	 * @return string|null
	 */
	public static function getCode($id)
	{
		$constants = static::getConstants();
		foreach ($constants as $constantCode => $constantId)
		{
			if ($constantId != $id)
			{
				continue;
			}

			return $constantCode;
		}

		return null;
	}
}