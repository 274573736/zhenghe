<?php
 goto AnX5S; AYn3z: Qy8_w: goto TJfhL; moR3J: return $this->result(0, ''); goto AYn3z; LtZ1d: $limit > 0 || ($limit = 8); goto he931; J_MBp: $results = pdo_getall("\x6d\x61\153\x65\x5f\x73\160\x65\145\144\x5f\x65\161\x75\x69\x70", array("\163\164\x61\164\x75\x73" => 0, "\x75\156\151\141\143\x69\144" => $GLOBALS["\165\x6e\x69\x61\143\x69\144"]), array("\151\x64", "\164\x69\164\x6c\145", "\151\155\147", "\x70\x72\x69\143\x65"), '', array("\x69\144\40\144\145\x73\143"), array($page, $limit)); goto IwUQ8; rVW01: $page = !empty($_GPC["\160\x61\147\145"]) ? intval($_GPC["\x70\141\147\145"]) : 0; goto PpX8A; TJfhL: foreach ($results as $k => $v) { $results[$k]["\151\155\147"] = $_W["\x73\x69\164\x65\x72\x6f\x6f\x74"] . "\141\144\x64\157\156\163\x2f\x6d\141\153\x65\x5f\163\160\x65\145\144\57\x63\x6f\162\x65\x2f\x70\x75\x62\x6c\x69\x63" . $v["\x69\x6d\x67"]; ULUpA: } goto bAF0D; AnX5S: global $_W, $_GPC; goto rVW01; bAF0D: fVDab: goto w0iZW; PpX8A: $limit = !empty($_GPC["\154\x69\x6d\x69\164"]) ? intval($_GPC["\x6c\x69\x6d\151\164"]) : 0; goto LtZ1d; he931: $page > 0 || ($page = 1); goto J_MBp; IwUQ8: if (!empty($results)) { goto Qy8_w; } goto moR3J; w0iZW: return $this->result(0, '', $results);