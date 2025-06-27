<?php
/**
 * Diploma Upload Form View
 * 
 * @package DiplomaVerifier
 * @license OSSN v8.1
 * @author Perplexity AI
 * @copyright 2025 Perplexity AI
 * @link https://www.ossn.com/
 */
// Security: Direct file access prevented
if (!defined('OSSN_ALLOW_SYSTEM_START')) {
    exit;
}
?>
<div class="ossn-layout-contents">
    <div class="ossn-ads-form">
        <div class="ossn-form-header">
            <h2><?php echo ossn_print('diploma:upload:title'); ?></h2>
        </div>
        
        <div class="ossn-form-body">
            <p><?php echo ossn_print('diploma:upload:instructions'); ?></p>
            
            <?php 
            // Render the pre-built form from controller
            echo $params['form']; 
            ?>
            <div class="ossn-form-footer">
                <div class="ossn-form-note">
                    <p>
                        <i class="fa fa-info-circle"></i>
                        <?php echo ossn_print('diploma:formats'); ?>: JPG, PDF
                        (<?php echo ossn_print('diploma:maxsize'); ?>: 5MB)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ossn-ads-form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.ossn-form-header {
    border-bottom: 1px solid #eee;
    margin-bottom: 15px;
    padding-bottom: 10px;
}
.ossn-form-footer {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #eee;
    color: #777;
}
.ossn-form-note {
    font-size: 12px;
}
</style>
