<?php
 use Model\Config; use Validate\IDMustBePositiveInt; use Server\app\Token; goto WITH1; Q44uL: $re = pdo_update("\155\141\153\x65\x5f\x73\x70\145\145\144\x5f\x6f\162\144\x65\x72\137\x70\151\x63\153\x63\x6f\x64\x65", ["\x65\156\x64\137\143\157\144\145" => $code], ["\157\x72\144\x65\162\x5f\x69\144" => $id]); goto S8xoR; xMpvv: if ($order["\163\164\x61\x74\165\163"] < 4) { goto Ry2Jd; } goto pKX8f; S8xoR: if ($re) { goto IHe33; } goto UEZT5; DE_mN: msg("\xe5\xb8\xa6\346\234\x89\345\x88\x86\346\234\xba\xe5\217\xb7\xe7\232\x84\xe5\217\xb7\347\240\x81\346\x97\xa0\346\263\x95\345\x8f\x91\351\x80\201\357\274\201"); goto Uz8dU; DwW7B: $code = pdo_getcolumn("\155\x61\153\145\137\163\x70\x65\145\x64\x5f\x6f\162\x64\145\x72\137\160\x69\x63\153\143\x6f\x64\x65", ["\x6f\x72\x64\145\162\137\151\144" => $id], "\145\x6e\x64\x5f\x63\157\144\x65"); goto HBiDf; gZVEP: $order = $query->from("\x6d\141\x6b\145\137\163\160\x65\145\144\137\157\x72\x64\x65\162\137\x72\151\144\145\162", "\x72")->select("\x6f\56\x73\x74\x61\x74\x75\x73")->innerjoin("\x6d\141\x6b\145\137\x73\160\x65\x65\x64\137\x6f\x72\144\145\x72", "\157")->on(["\x72\56\157\162\x64\145\x72\x5f\151\x64" => "\157\x2e\151\x64"])->where(["\x72\x2e\x6f\x72\144\x65\162\137\x69\x64" => $id, "\x72\x2e\x72\x69\144\x65\x72\x5f\x69\144" => $rider_id])->get(); goto BIm9I; RRbMK: msg("\350\256\242\345\215\225\344\xb8\215\345\255\x98\xe5\x9c\250\357\xbc\x81"); goto o4Rtu; BIm9I: if (!$order) { goto EReUs; } goto xMpvv; QQkrQ: $rider_id = Token::getCurrentRid(); goto TPZxt; ZX2sp: if (!(isset($result["\x43\157\144\145"]) || strtolower($result["\x43\157\x64\145"]) == "\157\153")) { goto V1gPO; } goto tUOcP; SyrNF: $result = send_aliyun_sms($phone["\x65\x6e\x64\137\160\150\157\x6e\x65"], ["\143\x6f\x64\x65" => $code], "\141\154\151\x5f\147\157\164\x6f\137\164\145\x6d\160"); goto ZX2sp; pKX8f: goto HjSF6; goto T55e9; JIVLN: Mqr4a: goto RMbJg; T55e9: EReUs: goto RRbMK; AfuH1: $id = $_GPC["\151\144"]; goto OMTty; tUOcP: $count = cache_load("\143\157\x64\x65" . $id); goto mbuyF; TPZxt: (new IDMustBePositiveInt())->goCheck(); goto AfuH1; F9gZS: $sendCount = cache_load("\143\157\144\145" . $id); goto DwW7B; K1uaN: msg("\xe8\xae\242\345\x8d\225\xe6\x9c\xaa\xe5\x8f\226\344\xbb\266"); goto YYywe; EYs0D: $endCodeSwitch = Config::get("\145\156\144\143\x6f\144\145\x5f\163\167\x69\164\143\x68"); goto cgUeu; dVfy_: swSfy: goto SyrNF; HBiDf: $phone = pdo_get("\x6d\141\153\x65\137\x73\160\x65\145\144\x5f\x6f\x72\x64\x65\162\137\x61\144\x64\162\145\x73\x73", ["\x6f\x72\x64\x65\162\x5f\151\144" => $id], ["\x65\156\x64\x5f\x70\150\x6f\x6e\x65", "\x65\x78\164\x65\x6e\163\x69\x6f\x6e\x5f\156\x75\x6d\142\x65\162"]); goto Xm08V; evI1d: cGYOr: goto em7E3; WITH1: global $_W, $_GPC; goto QQkrQ; aYe51: Ry2Jd: goto K1uaN; u9qmd: lrls3: goto F9gZS; o4Rtu: goto HjSF6; goto aYe51; OMTty: $query = load()->object("\161\165\x65\x72\171"); goto gZVEP; Zpmii: $num = pow(10, 5); goto BSqFF; Uz8dU: goto rrE4w; goto Q1LOS; Q1LOS: Ke394: goto Dbi5k; Dbi5k: if ($code) { goto swSfy; } goto Zpmii; RMbJg: if (isset($phone["\145\170\x74\x65\156\163\151\x6f\x6e\x5f\x6e\x75\x6d\142\145\162"]) && empty($phone["\x65\170\164\x65\156\163\151\157\156\137\156\x75\155\x62\145\x72"])) { goto Ke394; } goto DE_mN; YYywe: HjSF6: goto EYs0D; mbuyF: if ($count) { goto cGYOr; } goto a2iP0; a2iP0: cache_write("\143\x6f\144\145" . $id, 1); goto evI1d; c0Qir: msg($result["\115\145\x73\x73\x61\x67\145"] . "\xe8\xa1\245\xe5\x8f\x91\345\217\xb7\xe7\240\201\x3a" . $phone["\145\x6e\x64\137\x70\x68\157\x6e\145"]); goto WsoAe; OQqmo: msg("\346\224\266\xe4\273\xb6\347\xa0\201\xe5\x8a\237\xe8\x83\275\xe5\267\xb2\345\205\xb3\xe9\x97\255\357\xbc\214\346\227\240\351\x9c\x80\350\xa1\xa5\xe5\217\x91\xe7\237\255\xe4\xbf\241\xef\274\x81"); goto u9qmd; BSqFF: $code = mt_rand($num, $num * 10 - 1); goto Q44uL; W0gqw: msg("\350\xa1\245\345\x8f\221\347\x9f\255\xe4\xbf\241\346\254\241\xe6\225\260\350\xb6\x85\xe5\207\272\xef\xbc\x8c\346\x97\xa0\xe6\xb3\225\xe7\273\xa7\xe7\xbb\255\xe5\217\221\xe9\x80\201\56\xe8\241\xa5\xe5\x8f\x91\345\x8f\267\347\240\201\x3a" . $phone["\145\x6e\x64\x5f\160\x68\x6f\x6e\145"]); goto JIVLN; S3L91: IHe33: goto dVfy_; Xm08V: if (!($sendCount > 1)) { goto Mqr4a; } goto W0gqw; UEZT5: msg("\xe4\xbf\xae\346\224\xb9\345\244\261\xe8\264\xa5\357\xbc\201"); goto S3L91; qUvMA: V1gPO: goto c0Qir; cgUeu: if (!($endCodeSwitch == 1)) { goto lrls3; } goto OQqmo; em7E3: cache_write("\x63\157\x64\145" . $id, $count + 1); goto qUvMA; WsoAe: rrE4w: