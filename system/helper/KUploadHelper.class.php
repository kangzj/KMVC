<?php

/**
  A Helper to help upload file
 *
 * @author jasper
 */
class KUploadHelper {

    /**
     * upload file helper
     * @param string $form_file_name
     * @param string $absolute_upload_path
     * @param string $relative_upload_path
     * @param string $upload_file_name
     * @param array $allowed_file_extension
     * @return string
     * @throws KException
     */
    public static function upload($form_file_name, $absolute_upload_path, $relative_upload_path, $upload_file_name, $allowed_file_extension = array()) {
        if ($_FILES[$form_file_name]["error"] > 0) {
            return '';
        }
        $ext = pathinfo($_FILES[$form_file_name]["name"], PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed_file_extension)) {
            throw new KException('Invalid File Extension');
        }
        $filename = $upload_file_name . '.' . $ext;
        if (file_exists($absolute_upload_path . $filename)) {
            throw new KException($upload_file_name . ' already exists.');
        }
        if (!move_uploaded_file($_FILES[$form_file_name]["tmp_name"], $absolute_upload_path . $filename)) {
            throw new KException($form_file_name . ' move tmp file failed. ');
        }
        return $relative_upload_path . $filename;
    }

}
