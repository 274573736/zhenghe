<?php
 goto Zj_46; ngPNJ: $date = array(); goto wX4Hx; UDGo5: $s = date("\x59\x2d\155\x2d\x64", strtotime("\55" . ($cweek ? $cweek - 1 : 6) . "\40\x64\141\x79")); goto TqdO1; FIdbR: $date["\x64\141\164\145"][$i]["\164\151\155\145"] = date("\x64", strtotime("{$s}\53{$i}\x20\144\141\x79")); goto ECmnw; XyRGf: zROp1: goto K9fJh; u2j3T: $date["\144\141\164\145"][$i]["\163\x74\141\x74\165\x73"] = 1; goto XyRGf; KRjZz: $train = pdo_get("\x6d\x61\153\x65\x5f\163\x70\145\145\144\x5f\164\x72\x61\151\x6e\x5f\160\157\151\x6e\x74", array("\x69\144" => $train_id)); goto tcOG6; DXKKz: $date["\x6d\157\x72\156"] = !empty($train["\x6d\157\x72\156"]) ? $train["\x6d\157\162\x6e"] : "\60\72\60\60\x2d\60\72\60\60"; goto tutmy; wX4Hx: $cweek = date("\x77"); goto UDGo5; eu49R: global $_W, $_GPC; goto j2unO; tutmy: $date["\141\x66\164\x65\162"] = !empty($train["\141\x66\x74\x65\162"]) ? $train["\x61\x66\x74\x65\x72"] : "\x30\72\x30\x30\55\x30\72\x30\x30"; goto r9KLp; KbCgw: $date["\144\141\x74\x65"][$i]["\x73\164\x61\x74\165\163"] = 0; goto FIdbR; Gwo1q: goto I6gFY; goto Mrg_l; A6iE5: $i++; goto Gwo1q; EyY2_: if (!($i < 14)) { goto Xitah; } goto KbCgw; Zj_46: defined("\x49\x4e\x5f\111\101") or exit("\101\x63\x63\145\x73\163\40\x44\145\156\151\x65\144"); goto eu49R; TqdO1: $i = 0; goto KDsfb; KDsfb: I6gFY: goto EyY2_; j2unO: $train_id = !empty($_GPC["\x69\144"]) ? intval($_GPC["\x69\x64"]) : 0; goto KRjZz; K9fJh: cF0Zj: goto A6iE5; Ozm4e: if (!(in_array(date("\167", strtotime("{$s}\53{$i}\x20\144\x61\171")), $week) && strtotime(date("\171\55\155\55\144")) <= strtotime($date["\x64\x61\x74\x65"][$i]["\144\141\164\x65"]))) { goto zROp1; } goto u2j3T; ECmnw: $date["\x64\x61\x74\x65"][$i]["\144\141\164\145"] = date("\x59\55\x6d\x2d\x64", strtotime("{$s}\53{$i}\40\x64\x61\171")); goto Ozm4e; Mrg_l: Xitah: goto DXKKz; tcOG6: $week = !empty($train["\142\165\x73\151\156\145\x73\163\x5f\144\x61\x74\x65"]) ? explode("\54", $train["\142\165\163\x69\x6e\145\163\x73\137\x64\x61\x74\x65"]) : array(); goto ngPNJ; r9KLp: return $this->result(0, '', $date);