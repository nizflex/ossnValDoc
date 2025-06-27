<?php
/**
 * Diploma File Handler
 * 
 * @package DiplomaVerifier
 * @license OSSN v8.1
 * @author Nizone
 * @copyright 2025 Staff (c)
 * @link https://www.ossn.com/
 */

class Diploma extends OssnFile {
    /**
     * Initialize diploma file
     */
    public function initAttributes() {
        $this->OssnFile = new OssnFile;
        $this->type = 'user';
        $this->subtype = 'diploma:file';
        $this->accept = array(
            'application/pdf',
            'image/jpeg',
        );
        $this->setMaxSize(5); // 5MB max
    }

    /**
     * Get diploma by user GUID
     * 
     * @param int $user_guid
     * @return Diploma|false
     */
    public static function getByUserGuid($user_guid) {
        $files = new self;
        $files->owner_guid = $user_guid;
        $files->type = 'user';
        $files->subtype = 'diploma:file';
        $files = $files->getFiles();
         
        // Convert single object to array if needed
        if ($files && !is_array($files)) {
            $files = [$files];
        }

        return ($files && count($files) > 0) ? $files[0] : false;    
    }


    /**
     * Generate hashed filename
     * 
     * @param string $ext File extension
     * @return string
     */
    protected function generateFilename($ext) {
        return md5(time() . rand()) . '.' . $ext;
    }

    /**
     * Validate file against security requirements
     * 
     * @param array $file $_FILES array element
     * @return bool
     */
    protected function validateFile($file) {
        // Basic file validation
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return false;
        }
        
        // Check file extension
        $ext = $this->getFileExtension($file['name']);
        if (!in_array(strtolower($ext), array('jpg', 'jpeg', 'pdf'))) {
            return false;
        }
        
        // Check MIME type
        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, $this->accept)) {
            return false;
        }
        
        // Check file size
        if ($file['size'] > ($this->max_size * 1024 * 1024)) {
            return false;
        }
        
        return true;
    }

}
