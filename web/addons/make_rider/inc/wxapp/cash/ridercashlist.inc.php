<?php
 goto T2E38; M5N0c: $where["\x61\144\144\x5f\164\x69\155\x65\x20\x3c"] = strtotime("\53\61\x20\155\x6f\156\x74\x68", $ctime); goto HvE3H; C5nS6: if (!empty($results)) { goto WTJWb; } goto gifdW; gifdW: return $this->result(0, ''); goto yZzg1; yZzg1: WTJWb: goto Y7oWI; Y7oWI: $status = array("\xe7\212\xb6\346\200\x81\xe5\xbc\x82\xe5\270\xb8", "\345\276\x85\xe5\210\x92\xe6\254\276", "\345\267\xb2\xe5\xae\x8c\xe6\x88\220"); goto OE_q_; U1Tuf: r1OEU: goto OoIl2; Tjaqt: $where = array("\162\x69\x64\145\x72\137\x69\144" => $GLOBALS["\x43\x55\x52\x52\105\116\x54\x5f\x52\x49\104\105\122"]); goto dHe0R; HvE3H: OiA0Q: goto LGhCK; dHe0R: if (empty($ctime)) { goto OiA0Q; } goto f1X8Z; ELqJc: $page > 0 || ($page = 1); goto rhM3U; f1X8Z: $where["\x61\x64\x64\137\x74\x69\x6d\x65\x20\76\75"] = $ctime; goto M5N0c; T2E38: global $_W, $_GPC; goto xNh3B; OE_q_: foreach ($results as $k => $v) { goto guwU7; MJa6v: $results[$k]["\x61\144\x64\137\164\x69\155\x65"] = date("\x59\x2d\155\x2d\x64\x20\x48\72\x69", $v["\x61\x64\144\137\x74\151\155\145"]); goto NlR2s; guwU7: $results[$k]["\x61\155\x6f\165\156\x74"] = $v["\x74\x79\x70\x65"] > 0 ? "\x2b" . $v["\x61\x6d\157\x75\156\x74"] : "\55" . $v["\141\x6d\x6f\165\156\x74"]; goto ZVvrH; NlR2s: bN2ht: goto KQOO0; ZVvrH: $results[$k]["\163\164\141\164\165\x73"] = $status[$v["\x73\164\x61\164\165\163"]]; goto MJa6v; KQOO0: } goto U1Tuf; Vd8N_: $limit = !empty($_GPC["\154\x69\x6d\x69\x74"]) ? intval($_GPC["\154\151\155\x69\164"]) : 0; goto ELqJc; rhM3U: $limit > 0 || ($limit = 10); goto Tjaqt; xNh3B: $ctime = !empty($_GPC["\164\151\x6d\x65"]) ? strtotime($_GPC["\x74\x69\155\x65"]) : 0; goto cDDkb; cDDkb: $page = !empty($_GPC["\x70\x61\147\x65"]) ? intval($_GPC["\x70\141\147\145"]) : 0; goto Vd8N_; LGhCK: $results = pdo_getall("\155\x61\153\x65\x5f\163\x70\x65\x65\144\137\x72\x69\x64\x65\162\137\143\141\163\150\154\157\x67", $where, array(), '', array("\151\144\x20\144\x65\x73\x63"), array($page, $limit)); goto C5nS6; OoIl2: return $this->result(0, '', $results);