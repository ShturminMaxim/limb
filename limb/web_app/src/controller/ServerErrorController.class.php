<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 *
 * @copyright  Copyright &copy; 2004-2007 BIT
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 * @version    $Id: NotFoundController.class.php 5933 2007-06-04 13:06:23Z pachanga $
 * @package    $package$
 */

lmb_require('limb/web_app/src/controller/lmbController.class.php');

class ServerErrorController extends lmbController
{
  function doDisplay()
  {
    $this->response->header('HTTP/1.x 500 Server Error');
    $this->resetView();
    $this->setTemplate('server_error.html');
  }
}

?>