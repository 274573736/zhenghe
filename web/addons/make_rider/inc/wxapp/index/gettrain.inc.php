<?php
 goto Nsjif; im15r: $cityname = !empty($_GPC["\143\151\x74\171"]) ? $_GPC["\143\151\x74\171"] : ''; goto dUWaJ; uGt4B: if (!empty($train)) { goto lYZqF; } goto I6MBD; M34va: global $_W, $_GPC; goto im15r; R81ew: $cid = !empty($city["\151\x64"]) ? intval($city["\x69\144"]) : 0; goto VihsM; Nsjif: defined("\x49\x4e\137\x49\101") or exit("\x41\x63\x63\x65\163\163\40\104\x65\x6e\x69\x65\x64"); goto M34va; BId19: lYZqF: goto O5gyO; VihsM: $train = pdo_getall("\x6d\x61\x6b\x65\137\163\x70\x65\145\x64\137\164\162\x61\x69\x6e\x5f\160\157\151\x6e\x74", array("\165\x6e\151\x61\x63\151\x64" => $GLOBALS["\x75\x6e\x69\x61\143\151\x64"], "\143\x69\x74\x79\x5f\151\144" => $cid), array("\151\x64", "\x61\144\x64\162\145\163\163", "\x6e\141\x6d\145")); goto uGt4B; I6MBD: return $this->result(0, "\xe8\257\245\xe5\x9f\216\345\270\x82\xe6\232\x82\xe6\x97\240\xe5\x9f\xb9\xe8\256\xad\347\202\xb9\xef\xbc\x81"); goto BId19; dUWaJ: $city = pdo_get("\155\141\x6b\x65\137\x73\x70\x65\x65\144\137\x63\151\x74\171", array("\x6e\x61\155\x65" => $cityname, "\165\x6e\151\x61\x63\x69\x64" => $GLOBALS["\165\x6e\151\x61\x63\x69\x64"]), array("\x69\144")); goto R81ew; O5gyO: return $this->result(0, '', $train);