<?php
 use Validate\order\AddTips; goto vHR2a; bCpMe: $ordertype = 1; goto IrFef; qe0iu: if (!($payment == 2)) { goto z24t2; } goto kUnzy; fHWY6: if ($updateOrder && $cashLog && $updateValid) { goto LRGWI; } goto Z9oNt; Jnjfv: return $this->result(0, "\xe8\xae\xa2\xe5\x8d\225\344\270\215\345\255\x98\xe5\234\250\357\xbc\201"); goto DQ7kE; Is_Zf: updateUserMoney($GLOBALS["\x43\x55\122\x52\x45\x4e\x54\x5f\125\123\x45\x52"], $small_price); goto k7mRV; ylFgZ: CWM6M: goto JhiTj; zl7rM: $data = array("\x75\160\x64\x61\164\145\137\164\151\155\145" => time(), "\163\x6d\x61\x6c\x6c\x5f\160\162\x69\143\x65\x20\x2b\x3d" => $small_price, "\x70\141\171\x5f\160\x72\151\143\x65\40\53\75" => $small_price, "\164\157\x74\141\154\137\160\162\151\143\145\x20\x2b\x3d" => $small_price); goto UWSDV; QmoxX: return $this->result(0, '', array("\x70\141\171\x5f\160\141\x72\x61\x6d\163" => $pay_params, "\x61\143\143\x65\x70\164\137\x72\x69\144\x65\x72" => getScopeRider($id, $ordertype))); goto UIt8V; ZccPI: if ($payment == 1) { goto Q_2zY; } goto ALZDv; ONZC7: msg("\345\xa4\xa7\345\256\xa2\346\210\267\344\275\231\xe9\xa2\x9d\344\270\215\350\266\xb3\357\xbc\x8c\xe8\xaf\xb7\345\x85\x85\xe5\x80\274"); goto hLBAI; DNSQV: $ordertype = 2; goto lyBS4; wb1JH: pdo_commit(); goto eUZ8d; k7mRV: addCashLog($GLOBALS["\103\125\122\x52\105\x4e\124\x5f\125\123\105\x52"], $orderCode, $small_price, 0, "\344\xbd\231\351\xa2\x9d\345\x8a\240\xe5\260\x8f\xe8\xb4\xb9", $id, 1); goto lJsdh; DQ7kE: goto Calzy; goto bWU3d; FqDn4: $updateOrder = pdo_update("\155\141\x6b\x65\137\x73\x70\x65\145\x64\137\157\162\144\145\x72", $data, ["\151\x64" => $id]); goto wbO3X; cgk3V: SAzDr: goto Jnjfv; sgwRt: kWwnZ: goto QmoxX; U_qqV: if (!isset($result["\165\160\x64\141\x74\x65\x5f\164\x69\x6d\x65"])) { goto SAzDr; } goto Mb6B3; plU6X: if (!$result["\x62\165\x73\151\156\145\x73\x73\x5f\x69\x64"]) { goto Rb7wF; } goto DMf_e; UIt8V: goto vY32F; goto wtWPb; lIbKG: LRGWI: goto wb1JH; kSBB5: $differ = time() - $result["\165\160\144\141\164\145\x5f\164\x69\x6d\145"]; goto Mu7hC; R9L8E: $field = array("\x74\171\160\145", "\x62\x75\x73\151\156\x65\163\x73\x5f\151\x64", "\x67\145\x74\x5f\x74\x69\x6d\x65", "\x75\x70\x64\141\164\x65\137\164\x69\155\x65", "\157\x72\x64\x65\162\137\x63\157\144\145", "\160\x61\x79\155\145\x6e\164"); goto AL4TV; xmxhX: $small_price = sprintf("\45\56\x32\x66", $_GPC["\164\151\x70\137\155\157\156\145\171"]); goto f7ZOB; VKhro: z24t2: goto TqE85; IrFef: mVX4x: goto plU6X; hgD1a: return $this->result(0, "\xe8\267\235\xe7\246\273\344\270\x8b\xe6\254\241\345\x8a\240\350\264\271\350\xbf\230\345\211\251" . ($differ_time - $differ) . "\xe7\247\x92"); goto ylFgZ; wtWPb: Q_2zY: goto efruG; fvKta: if (!($businessBalance < $small_price)) { goto IMK_Y; } goto ONZC7; JhiTj: $orderCode = generate_order_code(18, "\155\x61\153\x65\x5f\163\x70\145\145\x64\137\x75\163\x65\162\137\143\x61\163\x68\154\x6f\147", "\x6f\162\x64\145\x72\137\143\157\x64\x65", "\x58\x46"); goto DNSQV; NTOvt: Rb7wF: goto ZccPI; AL4TV: $result = pdo_get("\x6d\141\153\145\x5f\x73\x70\x65\145\144\x5f\157\x72\144\145\x72", ["\151\144" => $id, "\165\x73\145\x72\137\x69\x64" => $GLOBALS["\103\125\x52\122\105\x4e\x54\137\125\123\x45\x52"]], $field); goto U_qqV; efruG: $data = array("\x75\x70\144\x61\164\145\137\x74\151\x6d\145" => time(), "\163\155\x61\x6c\154\137\160\x72\x69\x63\145\x20\53\75" => $small_price, "\160\x61\x79\137\x70\x72\x69\143\x65\x20\x2b\x3d" => $small_price, "\164\157\164\141\154\x5f\160\x72\x69\143\x65\x20\53\75" => $small_price); goto EAWFd; wOODG: vY32F: goto XpokV; wW_st: msg("\345\212\xa0\345\260\x8f\350\xb4\271\xe5\xa4\261\350\xb4\245\xef\xbc\201"); goto cb1pA; lJsdh: return $this->result(0, "\346\233\264\xe6\x96\xb0\346\x88\x90\345\x8a\x9f\357\xbc\201", ["\141\x63\x63\145\x70\x74\137\162\x69\x64\x65\162" => getScopeRider($id, $ordertype)]); goto wOODG; lyBS4: if (!is_numeric(substr($result["\x67\x65\x74\x5f\164\151\x6d\145"], -1))) { goto mVX4x; } goto bCpMe; wbO3X: $cashLog = addCashLog($GLOBALS["\103\x55\x52\122\105\116\x54\137\x55\123\x45\122"], $orderCode, $small_price, 0, "\xe5\xa4\xa7\xe5\xae\xa2\346\210\267\xe4\xbd\231\xe9\xa2\x9d\xe5\212\240\xe5\xb0\217\350\264\xb9", $id, 1, $result["\x62\165\x73\x69\x6e\145\163\x73\137\x69\144"]); goto Wms5H; eUZ8d: msg("\345\212\240\xe5\260\x8f\350\264\271\346\x88\x90\xe5\x8a\x9f", ["\x61\x63\143\145\x70\x74\137\162\x69\x64\x65\x72" => getScopeRider($id, $ordertype)]); goto VE3sl; hLBAI: IMK_Y: goto zl7rM; XxT5j: $pay_params = $this->pay($params); goto HbEeB; rca8k: if ($result["\x62\165\163\151\156\145\163\163\137\151\x64"]) { goto dfvnI; } goto FzwrU; f7ZOB: $id = $_GPC["\151\x64"]; goto O2Vn4; Mb6B3: if ($result["\160\141\x79\155\x65\x6e\164"] == 3) { goto s4kQ2; } goto rca8k; Wms5H: $updateValid = pdo_update("\155\x61\x6b\x65\x5f\163\x70\x65\x65\144\137\x62\165\x73\151\x6e\x65\163\x73", ["\166\x61\154\x69\x64\x20\55\75" => $small_price], ["\x69\x64" => $result["\142\165\163\x69\156\x65\163\x73\137\151\144"]]); goto fHWY6; Mu7hC: if (!($differ < $differ_time)) { goto CWM6M; } goto hgD1a; TqE85: Calzy: goto oC1dL; EAWFd: pdo_update("\155\x61\x6b\145\x5f\x73\x70\x65\x65\144\137\x6f\x72\x64\145\162", $data, array("\x69\144" => $id)); goto Is_Zf; O2Vn4: $payment = $_GPC["\160\141\171\x5f\155\145\164\x68\x6f\x64"]; goto R9L8E; DMf_e: $businessBalance = pdo_getcolumn("\x6d\x61\x6b\145\x5f\x73\x70\145\x65\144\137\142\165\163\x69\x6e\145\163\163", ["\151\x64" => $result["\142\165\163\151\x6e\x65\x73\x73\x5f\151\x64"]], "\x76\x61\154\x69\x64"); goto fvKta; HbEeB: if (!is_error($pay_params)) { goto kWwnZ; } goto iauoI; ALZDv: addCashLog($GLOBALS["\103\x55\122\122\105\116\x54\x5f\x55\x53\x45\x52"], $orderCode, $small_price, 0, "\xe5\xbe\256\xe4\xbf\241\xe5\212\240\xe5\xb0\217\350\xb4\xb9", $id, 0); goto jsDSB; VE3sl: lcImx: goto TiBnL; bWU3d: s4kQ2: goto s6BRF; cb1pA: goto lcImx; goto lIbKG; jNvpT: goto Calzy; goto XLVhQ; iauoI: return $this->result(0, "\xe6\224\257\xe4\xbb\x98\345\xa4\261\350\264\xa5\357\274\x8c\xe8\xaf\xb7\351\207\215\xe8\257\225"); goto sgwRt; vHR2a: (new AddTips())->goCheck(); goto iKJS9; TiBnL: goto qG3hS; goto NTOvt; XLVhQ: dfvnI: goto qe0iu; Z9oNt: pdo_rollback(); goto wW_st; jsDSB: $params = array("\x74\x69\x64" => $orderCode, "\x75\163\145\x72" => $_W["\x6f\x70\145\x6e\x69\144"], "\146\x65\x65" => sprintf("\45\x2e\x32\x66", $small_price), "\164\151\x74\154\145" => "\xe8\xae\242\345\215\225\xe6\x94\xaf\xe4\xbb\x98"); goto XxT5j; oC1dL: $differ_time = 30; goto kSBB5; UWSDV: pdo_begin(); goto FqDn4; iKJS9: global $_W, $_GPC; goto xmxhX; FzwrU: goto Calzy; goto cgk3V; kUnzy: return $this->result(0, "\345\244\247\345\xae\xa2\346\210\267\350\256\xa2\345\x8d\225\xe4\xb8\215\345\x8f\xaf\344\275\xbf\347\224\250\xe5\276\xae\344\xbf\xa1\346\224\257\344\273\230\345\212\240\345\xb0\x8f\350\264\xb9"); goto VKhro; s6BRF: return $this->result(0, "\347\x8e\xb0\351\207\221\346\224\257\xe4\xbb\x98\xe6\x97\240\346\263\x95\xe4\xbd\xbf\xe7\x94\250\345\212\xa0\345\260\x8f\350\xb4\xb9"); goto jNvpT; XpokV: qG3hS: