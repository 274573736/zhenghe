<?php
 goto YiC9A; bBt_K: $url = "\150\164\164\160\163\72\57\57\141\160\x69\x2e\x77\145\x69\170\151\156\56\161\161\56\x63\157\x6d\x2f\x77\x78\x61\x2f\x67\145\164\167\170\x61\x63\157\x64\145\77\x61\x63\x63\x65\163\163\x5f\x74\x6f\153\x65\x6e\75" . $token; goto W5OSo; ug_Vf: if (is_dir($path)) { goto qATET; } goto hIO02; QThl0: $file = "\x72\151\x64\x65\162\137\x75\163\x65\162" . $GLOBALS["\103\125\122\122\105\116\124\x5f\x52\x49\x44\105\122"] . "\x2e\160\156\x67"; goto YY7c1; W5OSo: $res = ihttp_request($url, json_encode($data)); goto yQ1kd; YY7c1: file_put_contents($path . $file, $res["\143\x6f\x6e\x74\x65\156\x74"]); goto LZj_y; yQ1kd: $path = MODULE_ROOT . "\x2f\143\157\x72\145\x2f\x70\x75\x62\154\x69\143\x2f\165\x70\x6c\x6f\141\144\x73\x2f\x71\162\x63\x6f\144\145\x2f"; goto ug_Vf; nhADt: $token = get_access_token($uni["\153\145\x79"], $uni["\x73\145\143\162\x65\164"]); goto X3ETL; m5A17: qATET: goto QThl0; KsnaW: $uni = pdo_get("\141\143\143\157\165\x6e\164\137\x77\x78\141\x70\x70", array("\x75\x6e\x69\141\x63\151\x64" => $GLOBALS["\x75\156\151\141\x63\151\144"]), array("\x6b\x65\x79", "\x73\x65\143\162\x65\x74")); goto nhADt; hIO02: mkdir($path, 0775, true); goto m5A17; YiC9A: global $_W, $_GPC; goto KsnaW; X3ETL: $riderid = !empty($GLOBALS["\x43\125\122\122\x45\116\x54\x5f\122\111\x44\105\x52"]) ? intval($GLOBALS["\x43\x55\x52\122\105\x4e\124\137\x52\x49\x44\105\122"]) : 0; goto YAh1W; YAh1W: $data = array("\160\141\164\x68" => "\x6d\x61\153\x65\x5f\x73\x70\x65\x65\144\x2f\162\x6f\x75\x74\145\x72\x2f\162\157\x75\164\145\162\77\162\145\x63\x6f\155\155\145\156\x64\137\151\144\75\x30\46\x72\151\x64\145\x72\x5f\x69\144\x3d" . $riderid, "\x77\x69\144\x74\x68" => 430); goto bBt_K; LZj_y: return $this->result(0, "\x73\165\143\143\145\x73\163", MODULE_URL . "\143\157\162\x65\x2f\x70\165\x62\x6c\151\x63\x2f\165\x70\154\157\141\144\163\x2f\x71\162\143\x6f\144\145\57" . $file);