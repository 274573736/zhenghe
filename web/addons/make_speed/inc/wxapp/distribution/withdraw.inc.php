<?php
 use Model\Config; goto jtPBP; qPDLI: v1BiE: goto ACZre; ssTza: goto ZZL4l; goto OJGWc; ACZre: ZZL4l: goto ch4je; TGY51: if (!($amount < $miniAmount)) { goto Rg3GI; } goto A3SD9; x9U_v: return $this->result(0, "\xe6\x82\xa8\xe8\xbf\230\344\xb8\215\xe6\230\257\346\x8e\250\xe5\271\277\xe5\x91\x98\xef\xbc\201"); goto URvBs; voBs5: $amount = sprintf("\x25\56\62\x66", $amount); goto nKlxg; A3SD9: return $this->result(0, "\346\234\200\xe4\275\216\xe6\217\x90\xe7\x8e\xb0\xe9\x87\221\351\242\235\xe4\xb8\272" . $miniAmount); goto rU_d7; bHDnL: if ($type != 1) { goto F01Vl; } goto WbPty; Ro1Ss: return $this->result(0, "\346\217\x90\347\216\260\344\275\x99\351\xa2\x9d\xe4\270\215\xe8\xb6\xb3\xef\274\201"); goto mETB4; BONwp: $w_amount = sprintf("\x25\56\62\146", $amount - $commission_charge_); goto TeV20; IzPgG: return msg("\346\x8f\220\xe7\x8e\260\347\xb1\273\xe5\x9e\x8b\351\x94\x99\xe8\xaf\xaf\xef\xbc\201"); goto n2f8D; rU_d7: Rg3GI: goto hwpLV; Dsg6u: $account = $_GPC["\x61\x63\143\x6f\165\156\164"] ? $_GPC["\x61\143\143\157\x75\156\x74"] : ''; goto Li4tq; imKPT: gckML: goto voBs5; rZClq: return msg("\350\257\267\xe8\xbe\x93\xe5\205\xa5\345\274\x80\xe6\x88\xb7\350\241\x8c\345\220\x8d\347\247\260"); goto qPDLI; OldDy: $type = $_GPC["\x74\171\x70\x65"]; goto Dsg6u; WWAQj: if (!empty($name)) { goto q882_; } goto rQ9n9; rQ9n9: return msg("\xe8\257\xb7\xe8\xbe\223\xe5\205\245\345\247\223\345\x90\x8d"); goto M0RIJ; WbPty: if ($type == 3) { goto Re7f4; } goto gnv96; a16Kp: return msg("\xe8\xaf\xb7\xe8\xbe\223\xe5\x85\xa5\xe6\217\x90\347\x8e\260\351\x87\x91\xe9\242\x9d"); goto imKPT; SVmFk: if ($is_distribution) { goto vBtin; } goto x9U_v; w1zp2: pdo_begin(); goto H1Ek2; rEf6T: $insert = ["\x6f\x70\x65\156\137\151\144" => $_W["\x6f\160\145\x6e\151\144"], "\x6f\x72\144\145\x72\x5f\156\x75\x6d" => "\104" . generate_order_code(), "\x75\163\145\x72\137\151\144" => $GLOBALS["\x43\125\122\x52\105\x4e\124\x5f\x55\x53\x45\x52"], "\144\151\x64" => $distribution["\x69\144"], "\141\155\157\x75\156\x74" => $w_amount, "\141\x63\143\157\165\156\x74" => $account, "\x6e\x61\x6d\145" => $name, "\142\x61\x6e\153" => $bank, "\163\145\x72\166\x65\x72\x5f\143\150\141\x72\147\x65" => $commission_charge_, "\163\x74\x61\x74\165\163" => 0, "\164\x79\160\x65" => $type, "\143\x72\x65\141\164\145\137\164\x69\x6d\145" => time(), "\165\x6e\x69\141\x63\x69\144" => $GLOBALS["\x75\x6e\151\141\143\151\x64"], "\143\151\x74\x79\x5f\x69\x64" => $city_id]; goto w1zp2; H1Ek2: $re = pdo_insert("\155\x61\x6b\145\137\163\160\145\x65\x64\x5f\x64\x69\x73\164\x72\x69\142\x75\x74\x69\x6f\x6e\137\167\x69\164\150\144\x72\x61\167", $insert); goto OGn2u; DdMLf: global $_GPC; goto YMXSj; UL_lw: $miniAmount = empty($miniAmount) ? 1 : sprintf("\45\56\x32\x66", $miniAmount); goto TGY51; nKlxg: if (in_array($type, [1, 2, 3])) { goto mJXoQ; } goto IzPgG; FoYJc: return $this->result(0, "\346\202\xa8\347\x9a\204\xe7\224\263\xe8\xaf\xb7\xe5\267\262\346\217\x90\xe4\xba\xa4\x2c\xe8\xaf\267\xe7\255\211\345\xbe\x85\xe5\267\245\344\xbd\234\xe4\xba\xba\345\x91\x98\xe5\xae\xa1\xe6\240\xb8", ["\x73\x74\x61\165\163" => "\157\x6b"]); goto XZjA3; mETB4: Twvvy: goto y1RtR; gK5dh: pdo_commit(); goto FoYJc; b19wS: pdo_rollback(); goto Mf3lf; hwpLV: $distribution = pdo_get("\x6d\141\153\145\x5f\163\160\x65\145\144\x5f\x64\x69\x73\164\x72\151\142\165\x74\151\157\x6e\137\144\151\163\164\x72\x69\142\165\x74\x6f\162", ["\x75\x73\x65\162\x5f\x69\144" => $GLOBALS["\x43\125\122\122\105\116\124\x5f\x55\123\x45\x52"]]); goto JlugW; XZjA3: IctD_: goto b19wS; JlugW: if (!($amount > $distribution["\143\x6f\155\x6d\151\x73\x73\x69\x6f\x6e"])) { goto Twvvy; } goto Ro1Ss; M0RIJ: q882_: goto ssTza; Li4tq: $city_id = $_GPC["\x63\x69\164\171\x5f\x69\144"] ? intval($_GPC["\143\x69\x74\x79\x5f\151\x64"]) : 0; goto hw1yB; OGn2u: $update_balack = pdo_update("\155\x61\x6b\145\x5f\163\x70\145\x65\x64\137\x64\x69\163\x74\x72\x69\x62\x75\x74\x69\157\x6e\137\x64\x69\163\164\x72\x69\x62\165\x74\157\x72", ["\x63\157\x6d\155\151\163\x73\x69\157\156\x20\x2d\x3d" => $amount, "\x70\x61\x79\137\143\x6f\x6d\155\151\163\x73\151\157\x6e\40\53\75" => $amount], ["\x75\x73\145\x72\137\151\x64" => $distribution["\165\x73\145\x72\137\x69\x64"]]); goto fmV27; y1RtR: $commission_charge = Config::get("\144\137\143\157\x6d\155\x69\163\163\x69\157\x6e\137\143\x68\141\x72\147\x65"); goto OqRYE; fmV27: if (!($update_balack && $re)) { goto IctD_; } goto gK5dh; safqA: if (!empty($amount)) { goto gckML; } goto a16Kp; jtPBP: $is_distribution = \Server\distribution\Distributor::isDistributor(); goto SVmFk; TeV20: global $_W; goto rEf6T; ch4je: $miniAmount = Config::get("\144\x5f\155\151\156\x69\137\141\155\157\x75\156\164"); goto UL_lw; n2f8D: mJXoQ: goto bHDnL; OqRYE: $commission_charge = isset($commission_charge) ? (double) $commission_charge : 0; goto zb1PR; URvBs: vBtin: goto DdMLf; YLAjt: F01Vl: goto WWAQj; OJGWc: Re7f4: goto w656P; hw1yB: $name = $_GPC["\156\x61\x6d\145"] ? $_GPC["\156\141\x6d\145"] : ''; goto Cp1c3; gnv96: goto ZZL4l; goto YLAjt; w656P: if (!empty($bank)) { goto v1BiE; } goto rZClq; zb1PR: $commission_charge_ = sprintf("\x25\x2e\62\x66", $amount * $commission_charge / 100); goto BONwp; Cp1c3: $bank = $_GPC["\142\141\x6e\x6b"] ? $_GPC["\x62\141\x6e\x6b"] : ''; goto safqA; YMXSj: $amount = $_GPC["\141\x6d\x6f\x75\x6e\x74"]; goto OldDy; Mf3lf: return msg("\xe6\x8f\220\347\216\xb0\345\244\261\xe8\xb4\245\xef\274\214\350\xaf\267\347\250\215\345\220\x8e\351\x87\x8d\xe6\226\260");