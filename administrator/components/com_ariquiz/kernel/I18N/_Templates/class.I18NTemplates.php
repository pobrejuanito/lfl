<?php
define('ARI_I18N_CACHE_TEMPLATE', "<?php\r\nif (!isset(\$GLOBALS['" . ARI_ROOT_NAMESPACE . "']['" . ARI_I18N_RES_ID . "']['%1\$s'])) \$GLOBALS['" . ARI_ROOT_NAMESPACE . "']['" . ARI_I18N_RES_ID . "']['%1\$s'] = array();\$GLOBALS['" . ARI_ROOT_NAMESPACE . "']['" . ARI_I18N_RES_ID . "']['%1\$s']['%2\$s'] = %3\$s;\r\n?>");
define('ARI_I18N_TEMPLATE_XML', '<?xml version="1.0" encoding="UTF-8"?>');
?>