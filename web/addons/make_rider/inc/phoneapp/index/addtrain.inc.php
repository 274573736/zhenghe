<?php
 defined("\x49\116\137\x49\101") or exit("\x41\x63\143\145\x73\x73\x20\x44\145\x6e\151\x65\x64"); use Server\app\Token; goto sSAyE; g2YEf: $data = array(); goto XhTZ_; cwQZy: IPNvt: goto Qr0zL; k4hVG: $add = pdo_insert("\155\141\153\145\137\163\160\x65\145\144\x5f\x74\x72\x61\151\x6e\137\162\x69\x64\145\x72", $data); goto fab9U; PV2UW: $data["\x74\151\155\x65"] = !empty($_GPC["\163\145\x6c\x65\x63\164\x5f\x64\141\164\x65"]) ? strtotime($_GPC["\x73\x65\x6c\145\143\x74\137\144\x61\x74\145"]) : 0; goto lNJ1c; fab9U: if (!empty($add)) { goto IPNvt; } goto Ihv35; XhTZ_: $data["\164\162\141\x69\156\137\151\x64"] = !empty($_GPC["\164\162\141\x69\156\x5f\x69\144"]) ? intval($_GPC["\x74\162\x61\x69\x6e\x5f\x69\x64"]) : 0; goto PV2UW; DpeSu: ngNK3: goto MAq1n; iWyKG: return $this->result(0, "\350\257\267\xe9\x80\211\346\213\251\xe5\237\xb9\xe8\256\xad\347\202\271\346\x88\x96\xe9\242\204\347\272\246\xe6\227\266\351\227\xb4\357\xbc\x81"); goto DpeSu; xahAJ: pdo_update("\x6d\x61\x6b\x65\x5f\x73\x70\145\145\x64\x5f\x72\151\x64\x65\x72", array("\x63\x69\164\x79\137\151\144" => !empty($city["\143\151\x74\171\137\151\144"]) ? $city["\x63\151\164\171\137\151\144"] : 0), array("\x69\x64" => $data["\162\x69\x64\145\x72\137\151\x64"])); goto ecOGE; lNJ1c: $data["\x74\x79\160\145"] = !empty($_GPC["\164\x69\x6d\145\x5f\x69\144\x78"]) ? 1 : 0; goto ljNhl; Ihv35: return $this->result(0, "\351\xa2\204\347\xba\xa6\xe6\217\x90\xe4\xba\xa4\345\xa4\261\350\264\xa5"); goto cwQZy; MAq1n: $data["\x72\151\x64\x65\x72\137\151\144"] = $rider_id; goto aBQq7; sSAyE: global $_W, $_GPC; goto uI1KM; ljNhl: if (!(empty($data["\x74\x72\141\x69\156\x5f\x69\144"]) || empty($data["\x74\x69\x6d\145"]))) { goto ngNK3; } goto iWyKG; uI1KM: $rider_id = Token::getCurrentRid(); goto g2YEf; aBQq7: pdo_delete("\155\x61\153\145\x5f\163\160\145\145\x64\137\x74\x72\x61\151\156\137\162\151\144\145\x72", array("\x72\x69\144\145\162\x5f\151\x64" => $data["\162\151\x64\x65\x72\x5f\151\144"])); goto k4hVG; Qr0zL: $city = pdo_get("\155\x61\153\145\x5f\x73\x70\145\x65\x64\137\164\162\141\x69\x6e\137\x70\157\x69\156\x74", array("\x69\x64" => $data["\x74\x72\141\x69\156\137\151\144"]), array("\x63\151\x74\x79\x5f\x69\x64")); goto xahAJ; ecOGE: return $this->result(0, "\xe9\242\x84\xe7\xba\xa6\346\x8f\x90\xe4\xba\xa4\346\210\220\345\212\x9f\xef\xbc\x81", array("\x73\165\x63\143\x65\163\x73"));