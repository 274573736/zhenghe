<?php
 goto AU0ie; RrekA: if (!empty($invite)) { goto FCxFd; } goto ZlcDV; WLqxT: $begin_time = time(); goto KOYay; cudI_: SRyG7: goto cxh_B; DmdGq: return $this->result(0, ''); goto cudI_; gQY6V: if (!empty($add)) { goto SRyG7; } goto DmdGq; EZWzt: FCxFd: goto Z3QTB; ZlcDV: return $this->result(0, ''); goto EZWzt; KOYay: $end_time = strtotime("\53" . $invite["\163\x68\x61\x72\145\137\144\141\171"] . "\40\144\x61\171"); goto hWc_S; qoS93: global $_W; goto UYEY9; miKmE: return $this->result(0, ''); goto BhH5v; Z3QTB: $coupon = pdo_get("\x6d\141\x6b\145\137\163\160\x65\145\x64\137\x75\x73\145\162\x5f\143\x6f\165\160\157\156\163", array("\x74\x79\160\x65" => "\x73\150\x61\162\x65", "\x75\x73\x65\162\x5f\151\x64" => $GLOBALS["\x43\125\122\x52\x45\x4e\124\137\125\x53\105\x52"], "\165\156\x69\141\143\x69\144" => $GLOBALS["\x75\156\151\141\x63\151\x64"]), array("\103\x4f\125\116\124\x28\x2a\x29\x20\x61\163\40\x63\157\165\x6e\164")); goto ygR3o; jWrZ5: $invite = !empty($invite["\x76\x61\154\165\145"]) ? unserialize($invite["\166\141\x6c\165\x65"]) : array(); goto RrekA; ygR3o: if (!($invite["\x73\150\141\162\x65\x5f\x6c\x69\155\x69\x74"] <= $coupon["\143\x6f\165\156\164"])) { goto vco3E; } goto miKmE; UZ2LP: $add = pdo_insert("\155\x61\x6b\145\137\x73\x70\145\x65\144\x5f\165\163\x65\x72\137\x63\157\x75\160\x6f\156\x73", $couponData); goto gQY6V; BhH5v: vco3E: goto WLqxT; AU0ie: defined("\111\116\137\111\101") or exit("\x41\x63\143\145\x73\x73\x20\x44\x65\x6e\x69\145\x64"); goto qoS93; UYEY9: global $_GPC; goto Zq9gt; hWc_S: $couponData = array("\164\171\x70\x65" => "\163\150\141\x72\145", "\x61\x6d\157\165\156\x74" => $invite["\x73\x68\141\162\145"], "\146\x75\154\154\137\x61\155\x6f\x75\x6e\x74" => $invite["\163\150\141\162\145\137\146\165\154\x6c"], "\x74\151\x70\163" => "\345\210\206\344\xba\xab\345\xa5\x96\xe5\x8a\xb1\xe4\xbc\230\346\x83\240\345\210\xb8", "\x75\163\x65\x72\x5f\151\x64" => $GLOBALS["\103\x55\x52\x52\x45\x4e\x54\x5f\x55\123\x45\x52"], "\x75\x6e\x69\141\143\151\144" => $GLOBALS["\x75\156\x69\141\x63\151\144"], "\x62\145\147\x69\156\137\164\151\x6d\x65" => $begin_time, "\145\170\160\x69\x72\145\x5f\164\x69\155\145" => $end_time, "\141\x64\x64\x5f\164\151\155\145" => $begin_time); goto UZ2LP; Zq9gt: $invite = pdo_get("\x6d\x61\x6b\145\137\x73\160\145\x65\x64\137\163\145\164\x74\x69\x6e\x67", array("\x6b\145\171" => "\165\163\145\162\x73\x5f\151\156\x76\x69\x74\x65", "\165\x6e\151\x61\143\x69\x64" => $GLOBALS["\165\156\x69\141\x63\151\x64"]), array("\166\141\x6c\x75\145")); goto jWrZ5; cxh_B: return $this->result(0, '', array(1));