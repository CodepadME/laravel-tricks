<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => ":attribute�����F���Ă��������B",
	"active_url"       => ":attribute���L����URL�ł͂���܂���B",
	"after"            => ":attribute�ɂ́A:date�ȍ~�̓��t���w�肵�Ă��������B",
	"alpha"            => ":attribute�̓A���t�@�x�b�h�݂̂������p�ł��܂��Bs",
	"alpha_dash"       => ":attribute�͉p�����ƃ_�b�V��(-)�y�щ���(_)�������p�ł��܂��B",
	"alpha_num"        => ":attribute�͉p�����������p�ł��܂��B",
	"array"            => ":attribute�͔z��łȂ��Ă͂Ȃ�܂���B",
	"before"           => ":attribute�ɂ́A:date�ȑO�̓��t�������p���������B",
	"between"          => array(
		"numeric" => ":attribute�́A:min����A:max�܂ł̐��������w�肭�������B",
		"file"    => ":attribute�ɂ́A:min kB����:max kB�܂ł̃T�C�Y�̃t�@�C�������w�肭�������B",
		"string"  => ":attribute�́A:min��������:max�����̊Ԃł��w�肭�������B",
		"array"   => ":attribute�̌���:min����:max�łȂ��Ă͂Ȃ�܂���B",
	),
	"confirmed"        => ":attribute�ƁA�m�F�t�B�[���h�Ƃ��A��v���Ă��܂���B",
	"date"             => ":attribute�͐��������t�ł͂���܂���B",
	"date_format"      => ":attribute�̃t�H�[�}�b�g��:format�ƈ�v���Ă��܂���B",
	"different"        => ":attribute��:other�ɂ́A�قȂ������e���w�肵�Ă��������B",
	"digits"           => ":attribute��:digits���łȂ���΂Ȃ�܂���B",
	"digits_between"   => ":attribute��:min������:max���łȂ���΂Ȃ�܂���B",
	"email"            => ":attribute�ɂ͐��������[���A�h���X�̌`�������w�肭�������B",
	"exists"           => "�I�����ꂽ:attribute�͐���������܂���B",
	"image"            => ":attribute�ɂ͉摜�t�@�C�����w�肵�Ă��������B",
	"in"               => "�I�����ꂽ:attribute�͐���������܂���B",
	"integer"          => ":attribute�͐����ł��w�肭�������B",
	"ip"               => ":attribute�ɂ́A�L����IP�A�h���X�����w�肭�������B",
	"max"              => array(
		"numeric" => ":attribute�ɂ́A:max�ȉ��̐��������w�肭�������B",
		"file"    => ":attribute�ɂ́A:max kB�ȉ��̃t�@�C�������w�肭�������B",
		"string"  => ":attribute�́A:max�����ȉ��ł��w�肭�������B",
		"array"   => ":attribute�̌���:max�ȉ��ɂ��Ă��������B",
	),
	"mimes"            => ":attribute�ɂ�:values�^�C�v�̃t�@�C�����w�肵�Ă��������B",
	"min"              => array(
		"numeric" => ":attribute�ɂ́A:min�ȏ�̐��������w�肭�������B",
		"file"    => ":attribute�ɂ́A:min kB�ȏ�̃t�@�C�������w�肭�������B",
		"string"  => ":attribute�́A:min�����ȏ�ł��w�肭�������B",
		"array"   => ":attribute�̌���:max�ȏ�ɂ��Ă��������B",
	),
	"not_in"           => "�I�����ꂽ:attribute�͐���������܂���B",
	"numeric"          => ":attribute�ɂ́A�������w�肵�Ă��������B",
	"regex"            => ":attribute�̃t�H�[�}�b�g�͐���������܂���B",
	"required"         => ":attribute�͕K���w�肵�Ă��������B",
	"required_if"      => ":attribute��:other��:value�̏ꍇ�ɕK�{�ƂȂ�܂��B",
	"required_with"    => ":attribute��:values�����݂��Ă���ꍇ�ɕK�{�ƂȂ�܂��B",
	"required_without" => ":attribute��:values�����݂��Ă���ꍇ�ɕK�{�ƂȂ�܂��B",
	"same"             => ":attribute��:values�����݂��Ă��Ȃ��ꍇ�ɕK�{�ƂȂ�܂��B",
	"size"             => array(
		"numeric" => ":attribute�ɂ�:size���w�肵�Ă��������B",
		"file"    => ":attribute�̃t�@�C���́A:size�L���o�C�g�łȂ��Ă͂Ȃ�܂���B",
		"string"  => ":attribute�̃t�@�C���́A:size�L���o�C�g�łȂ��Ă͂Ȃ�܂���B",
		"array"   => ":attribute��:size�����Ŏw�肵�Ă��������B",
	),
	"unique"           => ":attribute�Ɏw�肳�ꂽ�l�͊��ɑ��݂��Ă��܂��B",
	"url"              => ":attribute�̃t�H�[�}�b�g������������܂���B",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
