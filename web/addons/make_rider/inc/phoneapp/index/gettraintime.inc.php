<?php
 goto qjDNR; mBaC6: frY9K: goto m3RzW; dsU9W: $date["\x64\141\164\x65"][$i]["\x74\151\155\145"] = date("\144", strtotime("{$s}\53{$i}\x20\144\141\x79")); goto bmzqV; OUNda: VmaIu: goto fx2Vx; wq1sk: goto frY9K; goto OUNda; mARpQ: $cweek = date("\167"); goto ja9A0; I0i0n: global $_W, $_GPC; goto mhLbV; Cl17p: hPAVc: goto TFn5V; mhLbV: $train_id = !empty($_GPC["\x69\144"]) ? intval($_GPC["\x69\144"]) : 0; goto q6iIR; q6iIR: $train = pdo_get("\155\141\153\x65\x5f\x73\x70\145\145\144\x5f\x74\162\x61\151\x6e\137\x70\157\x69\x6e\164", array("\151\x64" => $train_id)); goto wOyGT; m3RzW: if (!($i < 14)) { goto VmaIu; } goto izsLt; O6fbk: $date = array(); goto mARpQ; ja9A0: $s = date("\131\x2d\155\55\x64", strtotime("\x2d" . ($cweek ? $cweek - 1 : 6) . "\40\144\x61\171")); goto M_v5l; qjDNR: defined("\111\x4e\137\111\x41") or exit("\101\x63\x63\145\163\x73\40\x44\145\156\x69\145\144"); goto I0i0n; lmMya: $date["\x61\146\164\x65\x72"] = !empty($train["\x61\146\164\x65\x72"]) ? $train["\x61\146\164\145\x72"] : "\60\x3a\x30\60\55\x30\72\60\x30"; goto oLyNP; DRmXZ: if (!(in_array(date("\x77", strtotime("{$s}\53{$i}\40\144\x61\171")), $week) && strtotime(date("\171\x2d\155\x2d\x64")) <= strtotime($date["\144\x61\x74\145"][$i]["\144\141\x74\145"]))) { goto hPAVc; } goto qlsxr; DRucm: $i++; goto wq1sk; bmzqV: $date["\144\x61\164\145"][$i]["\x64\141\164\x65"] = date("\x59\55\x6d\x2d\144", strtotime("{$s}\53{$i}\40\144\x61\171")); goto DRmXZ; izsLt: $date["\144\141\x74\x65"][$i]["\x73\x74\141\x74\165\163"] = 0; goto dsU9W; wOyGT: $week = !empty($train["\142\x75\x73\x69\156\x65\163\x73\137\144\x61\x74\x65"]) ? explode("\54", $train["\142\165\163\x69\x6e\145\163\163\137\144\x61\164\145"]) : array(); goto O6fbk; M_v5l: $i = 0; goto mBaC6; fx2Vx: $date["\155\x6f\x72\156"] = !empty($train["\x6d\x6f\x72\156"]) ? $train["\155\x6f\x72\156"] : "\x30\72\60\x30\x2d\x30\x3a\60\x30"; goto lmMya; qlsxr: $date["\144\141\164\145"][$i]["\x73\x74\141\x74\165\163"] = 1; goto Cl17p; TFn5V: zWzW4: goto DRucm; oLyNP: return $this->result(0, '', $date);