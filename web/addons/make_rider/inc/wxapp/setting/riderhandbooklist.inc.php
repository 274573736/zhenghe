<?php
 goto Xro_Z; FlO5b: ka5Dv: goto XH3zC; ZSk0i: $limit > 0 || ($limit = 8); goto tUviC; buz32: return $this->result(0, ''); goto FlO5b; G9SXR: $page = !empty($_GPC["\160\141\x67\x65"]) ? intval($_GPC["\160\x61\x67\x65"]) : 0; goto f_xe1; Ye1C6: $results = pdo_getall("\155\x61\x6b\x65\137\163\160\145\145\x64\x5f\150\x61\x6e\x64\142\x6f\x6f\153", array("\164\171\x70\x65" => 0, "\x75\x6e\x69\x61\143\151\x64" => $GLOBALS["\165\x6e\151\141\143\151\144"]), array("\x69\144", "\x69\143\157\156", "\x74\151\x74\154\x65"), '', array("\x69\x64\x20\x64\145\163\x63"), array($page, $limit)); goto st0pz; Oe_vK: if (!empty($results)) { goto ka5Dv; } goto buz32; f_xe1: $limit = !empty($_GPC["\x6c\x69\155\151\x74"]) ? intval($_GPC["\154\151\155\x69\164"]) : 0; goto ZSk0i; tUviC: $page > 0 || ($page = 1); goto Ye1C6; uiQR0: bFM58: goto Oe_vK; Xro_Z: global $_W, $_GPC; goto G9SXR; st0pz: foreach ($results as $k => $v) { $results[$k]["\151\x63\x6f\x6e"] = toimgurl($v["\151\143\x6f\156"]); uwJAi: } goto uiQR0; XH3zC: return $this->result(0, '', $results);