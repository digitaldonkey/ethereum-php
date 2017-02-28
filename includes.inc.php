<?php

$schema = json_decode(file_get_contents("./ethjs-schema.json"), true);


require_once './formatHelper.php';

require_once 'src/EthereumStatic.php';

require_once 'src/Ethereum.php';

require_once 'src/EthDataType.php';
require_once 'src/EthDataTypePrimitive.php';

require_once 'src/EthD.php';
require_once 'src/EthD20.php';
require_once 'src/EthD32.php';
require_once 'src/EthS.php';
require_once 'src/EthQ.php';
require_once 'src/EthB.php';
require_once 'src/EthBlockParam.php';
require_once 'src/EthData.php';
