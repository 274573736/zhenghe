<?php
 use Server\distribution\Distributor; goto pk97a; gm5up: d3o1F: goto kEjJe; CP0b7: if ($ids) { goto KA2CH; } goto NG7cX; Nwigj: foreach ($re as $k => &$v) { goto dHi0p; oanvk: $usercount = pdo_get("\155\141\153\145\x5f\x73\160\x65\145\x64\x5f\157\162\x64\x65\162", $conutWhere, array("\123\125\x4d\50\164\157\164\141\154\137\160\162\x69\143\x65\x29\x20\141\163\40\164\x6f\x74\x61\154\137\x70\x72\x69\143\x65\x20", "\103\x4f\x55\116\124\50\x69\144\51\x20\141\x73\40\143\157\x75\x6e\x74")); goto PLLHC; dZyO4: $v["\x63\157\x75\156\164"] = $usercount["\x63\x6f\x75\156\x74"]; goto WYQsf; iENrX: DxpH2: goto Fmrgw; dHi0p: $conutWhere = ["\163\164\x61\x74\x75\x73\x20\76" => 4, "\x75\163\145\162\137\x69\x64" => $v["\165\163\145\x72\x5f\x69\x64"]]; goto oanvk; WYQsf: $v["\143\162\x65\141\164\x65\x5f\x74\151\x6d\x65"] = date("\131\x2d\155\55\144\x20\x48\x3a\151\x3a\163", $v["\x63\x72\x65\141\x74\x65\x5f\x74\151\155\145"]); goto iENrX; PLLHC: $v["\x74\157\x74\x61\154\x5f\x70\x72\x69\143\x65"] = $usercount["\x74\157\164\141\154\137\x70\162\x69\x63\x65"] ? $usercount["\164\157\x74\x61\x6c\137\160\162\151\143\145"] : 0.0; goto dZyO4; Fmrgw: } goto QV9KG; aSYyi: $re = (new Distributor())->getlist($ids, $query, $field); goto NfgE1; KkxdP: goto ouaYV; goto q029v; Opzcp: if ($status == 2) { goto d3o1F; } goto KkxdP; S1Imb: goto ouaYV; goto QfUaF; pk97a: global $_GPC; goto xLKU3; A8_Gs: INjxU: goto BYnJL; F3Ett: $re = $query->from("\155\x61\153\x65\x5f\163\160\x65\145\144\137\x64\x69\163\164\x72\x69\x62\x75\164\151\x6f\156\137\144\151\x73\x74\x72\x69\x62\165\x74\157\162", "\x64")->innerjoin("\155\141\153\x65\137\x73\160\x65\145\x64\x5f\x75\x73\x65\162", "\x75")->on(["\144\x2e\x75\163\145\x72\x5f\151\x64" => "\165\x2e\x69\144"])->where($where)->select($field)->orderby("\x64\56\x69\144\40\144\x65\163\143")->getall(); goto Nwigj; oKQCW: $field = ["\x64\x2e\x75\163\x65\162\137\151\144", "\x64\56\x63\x72\x65\141\x74\x65\x5f\x74\151\x6d\145", "\x75\56\156\x69\143\153\x5f\x6e\141\x6d\145", "\165\56\x61\x76\x61\164\141\162"]; goto iTSaK; KmpHr: $ids = Distributor::get_downline_list($re, $uid, 2); goto qGy_L; qGy_L: if ($ids) { goto INjxU; } goto LG3hp; vSl1U: $re = pdo_getall("\155\x61\x6b\x65\137\163\x70\x65\x65\144\x5f\x64\x69\x73\164\x72\x69\142\x75\x74\151\x6f\156\x5f\144\151\x73\x74\x72\151\x62\x75\164\x6f\x72", ["\160\151\x64\x20\74\76" => 0, "\165\x6e\x69\x61\143\151\x64" => $GLOBALS["\165\156\x69\x61\143\x69\x64"]], ["\165\x73\145\x72\x5f\x69\144", "\x70\x69\x64"]); goto KmpHr; iTSaK: $query = load()->object("\161\x75\145\x72\x79"); goto JdiWe; QV9KG: vtsAt: goto S1Imb; JdiWe: if ($status == 0) { goto l79OX; } goto ss2o0; NfgE1: goto ouaYV; goto gm5up; kEjJe: $re = pdo_getall("\155\141\x6b\145\x5f\163\x70\x65\x65\x64\x5f\x64\x69\x73\164\162\x69\142\x75\164\x69\x6f\156\137\144\x69\x73\164\162\x69\x62\x75\x74\157\162", ["\160\151\144\40\74\76" => 0, "\165\x6e\151\x61\x63\x69\144" => $GLOBALS["\165\156\151\x61\x63\151\144"]], ["\165\163\145\x72\137\151\x64", "\160\x69\x64"]); goto cCKZw; xLKU3: $status = $_GPC["\x73\164\141\164\165\163"]; goto qNUMi; eb7Pq: $ids = array_column($ids, "\165\x73\145\162\137\x69\144"); goto gwKWr; LG3hp: return $this->result(0, '', []); goto A8_Gs; b96b_: ouaYV: goto JcI93; BYnJL: $ids = array_column($ids, "\165\163\145\162\137\151\x64"); goto aSYyi; NG7cX: return $this->result(0, '', []); goto BW1_U; gwKWr: $re = (new Distributor())->getlist($ids, $query, $field); goto b96b_; cCKZw: $ids = Distributor::get_downline_list($re, $uid, 3); goto CP0b7; q029v: l79OX: goto Fk6CE; QfUaF: AoSjD: goto vSl1U; ss2o0: if ($status == 1) { goto AoSjD; } goto Opzcp; Fk6CE: $where = ["\x64\x2e\160\x69\144" => $uid]; goto F3Ett; BW1_U: KA2CH: goto eb7Pq; qNUMi: $uid = $GLOBALS["\103\125\x52\x52\x45\116\124\x5f\x55\123\x45\122"]; goto oKQCW; JcI93: return $this->result(0, "\163\x75\x63\x63\x65\163\x73", $re);