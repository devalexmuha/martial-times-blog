<?php

function e( $value ) {
	return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8' );
}

function seoSlug( string $slug ): string {
	$map  = [
		'а' => 'a',
		'б' => 'b',
		'в' => 'v',
		'г' => 'g',
		'ґ' => 'g',
		'д' => 'd',
		'е' => 'e',
		'є' => 'ye',
		'ж' => 'zh',
		'з' => 'z',
		'и' => 'y',
		'і' => 'i',
		'ї' => 'yi',
		'й' => 'y',
		'к' => 'k',
		'л' => 'l',
		'м' => 'm',
		'н' => 'n',
		'о' => 'o',
		'п' => 'p',
		'р' => 'r',
		'с' => 's',
		'т' => 't',
		'у' => 'u',
		'ф' => 'f',
		'х' => 'kh',
		'ц' => 'ts',
		'ч' => 'ch',
		'ш' => 'sh',
		'щ' => 'shch',
		'ю' => 'yu',
		'я' => 'ya',
		'ь' => '',
		'ъ' => '',
		'ё' => 'yo',
		'э' => 'e',
		'ы' => 'y',
		'ў' => 'u',
		'љ' => 'lj',
		'њ' => 'nj',
		'ћ' => 'c',
		'ќ' => 'k',
		'ђ' => 'dj',
		'џ' => 'dz',
		'ѕ' => 'dz'
	];
	$slug = trim( $slug );
	$slug = mb_strtolower( $slug, 'UTF-8' );
	$slug = strtr( $slug, $map );
	$slug = preg_replace( '/[^a-z0-9]+/', '-', $slug );
	$slug = preg_replace( '/-+/', '-', $slug );
	$slug = trim( $slug, '-' );

	return $slug;
}

function format_date( string $date, int $flag = 1 ): null|string {
	if ( ! empty( $date ) ) {
		switch ( $flag ) {
			case 1:
				return date( 'Y-m-d H:i:s', strtotime( $date ) );
			case 2:
				return date( 'd M Y', strtotime( $date ) );
			case 3:
				return date( 'j F Y', strtotime( $date ) );
		}
	}

	return null;
}

if ( ! function_exists( 'dd' ) ) {
	function dd( ...$vars ): never {
		foreach ( $vars as $var ) {
			echo '<pre style="background:#1a1a1a;color:#e6e6e6;padding:1rem;'
			     . 'border-radius:8px;font-size:14px;line-height:1.5;overflow:auto;">';
			var_dump( $var );
			echo '</pre>';
		}
		die( 1 );
	}
}

function route_url( array $params ): string {
	return str_replace( '%2F', '/', http_build_query( $params ) );
}


