<?php
/*
Plugin name: Hashed Directory Structure
Description: Maintaining a high level of performance of files accessibility through hashing
Author: Fenix
Version: 1.0.0
*/

// Check if we are using local Composer
if (file_exists(__DIR__ . '/vendor')) {
    require __DIR__ . '/vendor/autoload.php';
}


add_action('plugins_loaded', function () {
    add_filter('wp_handle_upload_prefilter', 'genRandom_pre_upload');
    add_filter('wp_handle_upload', 'genRandom_post_upload');
});

add_action('genRandom_pre_upload', 'genRandom_pre_upload');
add_action('genRandom_post_upload', 'genRandom_post_upload');

// ACF Image Aspect Ratio Crop compat
add_filter('aiarc_pre_customize_upload_dir', 'genRandom_pre_upload');
add_filter('aiarc_after_customize_upload_dir', 'genRandom_post_upload');

function genRandom_pre_upload($file)
{
    add_filter('upload_dir', 'genRandom_custom_upload_dir');
    return $file;
}

function genRandom_post_upload($file_info)
{
    remove_filter('upload_dir', 'genRandom_custom_upload_dir');
    return $file_info;
}

function genRandom_custom_upload_dir($path)
{
    if (!empty($path['error'])) {
        return $path;
    }

    $uuid4 = \Ramsey\Uuid\Uuid::uuid4();
    $uuid = $uuid4->getBytes();
    
    $encoded = \xobotyi\basen\Base36::encode($uuid);

    $folder_depth = apply_filters('genRandom_folder_depth', 1);

    if ($folder_depth > 1) {
        $encoded = str_split($encoded);
        foreach ($encoded as $index => &$part) {
            if ($index < $folder_depth - 1) {
                $part = $part . '/';
            }
        }
        $encoded = implode('', $encoded);
    }

    $customdir = "/$encoded";
    $path['path'] = str_replace($path['subdir'], '', $path['path']); //remove default year/month directory
    $path['url'] = str_replace($path['subdir'], '', $path['url']);
    $path['subdir'] = $customdir;
    $path['path'] = $path['path'] . $customdir;
    $path['url'] = $path['path'] . $customdir;
    return $path;
}

if ( ! function_exists( 'genRandom_unique_id' ) ) :
    function genRandom_unique_id( $limit = 11, $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-' ) {
      $limit = ( defined( 'genRandom_LENGTH' ) && genRandom_LENGTH ) ? genRandom_LENGTH : $limit;
      $characters = ( defined( 'genRandom_CHARS' ) && genRandom_CHARS ) ? genRandom_CHARS : $chars;
      $randstring = '';
      for ($i = 0; $i < $limit; $i++) {
        $randstring .= $characters[rand(0, strlen($characters))];
      }
      return $randstring;
    }
  endif;
  
  if ( ! function_exists( 'genRandom_auto_rename' ) ) :
    function genRandom_auto_rename( $attachment, $ignored = 'pdf, zip' ) {
      // Get file extensions to ignore from settings
      $ignored_exts_raw = defined( 'genRandom_IGNORE' ) ? genRandom_IGNORE : $ignored;
      $ignored_exts = ! empty( $ignored_exts_raw )
        ? array_map( 'trim', explode( ',', $ignored_exts_raw ) ) : [];
  
      // Get current file extension
      $current_ext = pathinfo( basename( $attachment['name'] ), PATHINFO_EXTENSION );
  
      // Check if current file extension in ignored list
      if ( in_array( $current_ext, $ignored_exts ) ) return $attachment;
  
      // Apply new unique file name
      $processed_ext = empty( $current_ext ) ? '' : '.' . $current_ext;
      $attachment['name'] = sanitize_file_name( genRandom_unique_id() . $processed_ext );
      $attachment['title'] = 'wtf';
  
      // Return new attachment object
      return $attachment;
    }
    add_filter( 'wp_handle_upload_prefilter', 'genRandom_auto_rename', 20, 2 );
  endif;
  