<?php
$result['stop_perso'] = $this->Ma->mdvs($result['stop_perso']);
echo json_encode(compact('result'));