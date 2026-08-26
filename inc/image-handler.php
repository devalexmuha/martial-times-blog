<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

function image_upload( array $files ): null|string {
	if ( empty( $files['image'] ) || $files['image']['error'] !== 0 || $files['image']['size'] === 0 ) {
		return null;
	}
	if ( getimagesize( $files['image']['tmp_name'] ) === false ) {
		return null;
	}

	$base = seoSlug( pathinfo( $files['image']['name'], PATHINFO_FILENAME ) . '-' . date( 'Y-m-d H:i:s') );
	$dir  = dirname( __DIR__ ) . '/storage/public';

	$manager = ImageManager::usingDriver( Driver::class );

	$manager->decodePath( $files['image']['tmp_name'] )
	        ->encodeUsingFormat( Format::WEBP, quality: 80 )
	        ->save( "$dir/$base-full.webp" );

	$manager->decodePath( $files['image']['tmp_name'] )
	        ->scale( width: 1000 )
	        ->encodeUsingFormat( Format::WEBP, quality: 80 )
	        ->save( "$dir/$base-large.webp" );

	$manager->decodePath( $files['image']['tmp_name'] )
	        ->scale( width: 700 )
	        ->encodeUsingFormat( Format::WEBP, quality: 80 )
	        ->save( "$dir/$base-medium.webp" );

	$manager->decodePath( $files['image']['tmp_name'] )
	        ->scale( width: 400 )
	        ->encodeUsingFormat( Format::WEBP, quality: 80 )
	        ->save( "$dir/$base-small.webp" );

	return "/storage/$base.webp";
}

function image_get_size( string $image_path, string $size ): string {
	$image_location  = pathinfo( $image_path, PATHINFO_DIRNAME );
	$image_name      = pathinfo( $image_path, PATHINFO_FILENAME );
	$image_extension = pathinfo( $image_path, PATHINFO_EXTENSION );

	return $image_location . '/' . $image_name . "-$size." . $image_extension;
}
