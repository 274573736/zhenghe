<?php
 use Server\app\Token; goto GSwFt; qwFPo: $rider = pdo_get("\155\x61\153\145\x5f\x73\160\145\x65\x64\x5f\x72\151\x64\145\x72", array("\151\144" => $rider_id), array("\x6d\157\x62\x69\x6c\145")); goto ATgu1; WYdrg: E6cH7: goto mN_q9; c1UfW: return $this->result(0, "\350\257\267\xe8\xbe\x93\xe5\205\xa5\xe6\xad\243\xe7\241\256\347\x9a\204\xe6\211\213\xe6\x9c\272\345\217\267"); goto meyCG; KAU1u: AQaPv: goto sr9nj; pMSg0: if (!(!empty($nextTime) && $nextTime > time())) { goto jLRFK; } goto bQVY7; jgigR: $mobile = !empty($_GPC["\155\x6f\x62\x69\154\145"]) ? $_GPC["\155\x6f\142\x69\154\x65"] : ''; goto Mbbs1; q42iH: jLRFK: goto e248n; SlN0j: return $this->result(0, "\xe4\277\xae\xe6\x94\xb9\xe5\244\xb1\xe8\xb4\xa5\x2c\350\257\245\345\x8f\267\347\240\x81\345\267\262\xe8\xa2\xab\346\xb3\250\xe5\206\x8c"); goto WYdrg; eLgre: $sms = send_aliyun_sms($rider["\x6d\x6f\142\x69\154\145"], array("\x63\x6f\144\145" => $randCode)); goto DlnSV; xO28k: $nextTime = cache_load("\163\155\x73\137\156\x65\x78\164\124\x69\155\x65"); goto pMSg0; bQVY7: return $this->result(0, "\xe8\267\235\347\246\xbb\344\xb8\213\346\254\241\xe5\x8f\x91\xe9\x80\x81\xe8\277\x98\345\x89\251" . ($nextTime - time()) . "\xe7\247\x92\x7e"); goto q42iH; cnmHv: $smsMobile = cache_load("\163\x6d\163\137\155\157\x62\x69\x6c\x65"); goto wkYOH; ZBiXa: return $this->result(0, '', array(1 => cache_load("\x73\x6d\x73\x5f\155\x6f\142\151\154\x65"))); goto lX5LR; Mbbs1: $smscode = !empty($_GPC["\x63\x6f\x64\145"]) ? $_GPC["\143\x6f\144\x65"] : ''; goto a2y48; Lnqwj: V0f9W: goto xO28k; ZhSC5: return $this->result(0, "\xe6\233\xb4\xe6\226\xb0\345\xa4\261\350\264\245\xef\274\x8c\350\xaf\267\347\xa8\215\345\220\x8e\351\207\x8d\xe8\xaf\225"); goto RQ8j_; GSwFt: global $_W, $_GPC; goto gRcl3; gRcl3: $rider_id = Token::getCurrentRid(); goto jgigR; bgN3R: if (!($randCode != $smscode)) { goto x5ta5; } goto Gvg8f; umnd8: cache_delete("\x73\x6d\x73\137\155\157\x62\x69\154\x65"); goto gUr6r; RQ8j_: mab2W: goto uf82u; m5wO9: load()->func("\143\141\x63\x68\145"); goto bDtD0; mN_q9: cache_delete("\163\x6d\x73\137\x43\x6f\x64\x65"); goto wOiqW; NPsjS: $srider = pdo_get("\x6d\141\153\145\137\163\160\145\x65\x64\x5f\x72\x69\x64\145\x72", array("\155\157\142\151\154\x65" => $mobile), array("\151\x64")); goto qb1PL; a2y48: $sendSms = !empty($_GPC["\151\163\137\x73\145\156\x64"]) ? true : false; goto m5wO9; qb1PL: if (empty($srider)) { goto E6cH7; } goto SlN0j; wOiqW: cache_delete("\x73\155\163\x5f\x6e\145\x78\164\124\x69\x6d\145"); goto umnd8; ng82a: $randCode = cache_load("\163\155\x73\137\103\x6f\x64\145"); goto Q6vXu; gUr6r: $up = pdo_update("\x6d\141\153\145\137\163\x70\145\x65\x64\x5f\162\151\x64\x65\x72", array("\155\157\x62\x69\x6c\x65" => $mobile), array("\x69\144" => $GLOBALS["\x43\125\x52\122\105\116\x54\x5f\x52\x49\104\105\122"])); goto CkaLr; h21D6: VCPi1: goto bgN3R; e248n: $randCode = mt_rand(1000, 9999); goto eLgre; CkaLr: if (!empty($up)) { goto mab2W; } goto ZhSC5; f1Z34: cache_write("\x73\x6d\163\x5f\x6d\x6f\x62\151\154\x65", $rider["\155\157\x62\x69\154\145"]); goto ZBiXa; Q6vXu: $nextTime = cache_load("\x73\x6d\x73\x5f\156\x65\170\164\x54\x69\155\x65"); goto cnmHv; f8wmG: return $this->result(0, "\xe5\xb0\232\346\234\252\xe6\216\xa5\xe6\224\xb6\347\237\255\346\201\xaf\351\252\214\xe8\xaf\201\347\240\x81" . "\x2d" . $randCode . "\x2d" . $nextTime . "\55" . $smsMobile); goto h21D6; sr9nj: cache_write("\x73\155\163\137\103\157\144\145", $randCode); goto VbO3m; DlnSV: if (!(empty($sms["\103\157\x64\145"]) || strtolower($sms["\103\x6f\144\145"]) !== "\157\153")) { goto AQaPv; } goto dsblM; B9ggK: x5ta5: goto NPsjS; dsblM: return $this->result(0, !empty($sms["\115\x65\x73\x73\x61\x67\x65"]) ? $sms["\x4d\x65\163\x73\141\x67\145"] : "\xe7\x9f\xad\xe4\277\241\345\x8f\x91\351\200\201\345\244\261\xe8\xb4\245\x21"); goto KAU1u; XBxxz: if (!(empty($mobile) || !is_mobile($mobile))) { goto X4g9M; } goto c1UfW; Gvg8f: return $this->result(0, "\350\xaf\xb7\xe8\276\x93\345\x85\245\346\xad\xa3\xe7\xa1\xae\xe7\x9a\x84\351\252\x8c\xe8\xaf\201\347\240\x81"); goto B9ggK; ATgu1: if (!empty($rider["\x6d\157\142\151\154\x65"])) { goto V0f9W; } goto XjCuV; lX5LR: MVc1E: goto XBxxz; bDtD0: if (!$sendSms) { goto MVc1E; } goto qwFPo; meyCG: X4g9M: goto ng82a; VbO3m: cache_write("\163\155\163\x5f\156\145\x78\x74\124\x69\x6d\145", time() + 180); goto f1Z34; XjCuV: return $this->result(0, "\346\x9c\252\xe6\x9f\245\xe8\257\242\345\210\xb0\xe5\216\237\346\x89\213\xe6\234\xba\345\217\xb7\54\xe5\217\221\351\x80\201\xe5\244\xb1\350\xb4\245"); goto Lnqwj; wkYOH: if (!(empty($randCode) || empty($nextTime) || empty($smsMobile))) { goto VCPi1; } goto f8wmG; uf82u: return $this->result(0, '', array("\x6d\163\147" => "\346\233\xb4\xe6\226\260\xe6\210\220\345\212\237"));