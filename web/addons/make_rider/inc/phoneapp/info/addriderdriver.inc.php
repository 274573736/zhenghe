<?php
 defined("\x49\116\x5f\x49\x41") or exit("\101\x63\143\x65\x73\x73\x20\x44\145\x6e\x69\x65\144"); use Server\app\Token; goto ywaB6; fwjE5: $img = !empty($_GPC["\x69\x6d\x67\137\x75\x72\x6c"]) ? explode("\54", $_GPC["\151\x6d\147\137\x75\x72\x6c"]) : array(); goto aL3E5; oGi7s: if (empty($add)) { goto i3fRr; } goto OccXR; c3yDp: $data = array(); goto fwjE5; EIzC8: list($data["\x63\141\x72\x64\x5f\x69\155\x67\61"], $data["\143\141\162\x64\x5f\x69\155\147\x32"]) = $imgs; goto YLUz7; G6GUx: $data["\x72\151\144\x65\162\x5f\151\x64"] = $rider_id; goto DNLe6; SJVgn: $data["\143\x61\162\144\137\164\x79\x70\x65"] = !empty($_GPC["\x63\141\162\x5f\x74\x79\x70\145"]) ? trim($_GPC["\x63\x61\x72\x5f\x74\x79\x70\145"]) : ''; goto Cy_xN; aL3E5: $data["\143\141\x72\x64\x5f\x6e\165\x6d"] = !empty($_GPC["\143\x61\x72\137\156\x75\155"]) ? trim($_GPC["\x63\141\162\137\156\x75\155"]) : ''; goto SJVgn; o_W23: $result = pdo_get("\x6d\x61\153\145\x5f\163\160\145\x65\x64\137\162\x69\x64\x65\162\137\x64\x72\x69\x76\145\x72", array("\x72\151\144\145\162\x5f\151\x64" => $rider_id)); goto kIR92; CXjp1: sYa7k: goto c3yDp; OccXR: return $this->result(0, '', array($add)); goto FO3QX; Cy_xN: $data["\143\x61\162\144\x5f\x74\x69\155\145"] = !empty($_GPC["\144\x61\x74\145"]) ? $_GPC["\144\141\164\145"] : ''; goto dl5bQ; EgjSe: return $this->result(0, ''); goto e3vl_; P4rwu: pdo_delete("\x6d\141\x6b\x65\137\x73\x70\145\x65\144\x5f\162\x69\x64\145\162\137\144\162\151\166\x65\162", array("\162\x69\x64\x65\x72\x5f\x69\144" => $rider_id)); goto iYy6Q; FO3QX: i3fRr: goto HhWid; Kwdls: $result["\143\141\162\144\x5f\151\x6d\147\137\x64\157\167\156\x31"] = toimgurl($result["\x63\x61\162\144\x5f\151\x6d\147\61"]); goto uFcgL; YLUz7: $data["\141\x64\x64\x5f\164\151\x6d\145"] = $data["\165\160\x64\141\164\145\x5f\x74\151\155\x65"] = time(); goto G6GUx; DNLe6: $data["\x75\x6e\x69\141\143\x69\144"] = $GLOBALS["\x75\156\x69\x61\143\151\x64"]; goto P4rwu; wy5OS: if (empty($_GPC["\x69\x6e\x66\157"])) { goto sYa7k; } goto o_W23; e3vl_: Nu8Y1: goto Kwdls; Qi0CC: $imgs[1] = !empty($img[1]) ? $img[1] : ''; goto EIzC8; kIR92: if (!empty($result)) { goto Nu8Y1; } goto EgjSe; DZ1vN: return $this->result(0, '', $result); goto CXjp1; ywaB6: global $_W, $_GPC; goto FgAOh; uFcgL: $result["\x63\x61\x72\x64\x5f\151\x6d\x67\137\x64\x6f\167\156\x32"] = toimgurl($result["\143\x61\162\x64\137\x69\x6d\147\62"]); goto DZ1vN; dl5bQ: $imgs[0] = !empty($img[0]) ? $img[0] : ''; goto Qi0CC; iYy6Q: $add = pdo_insert("\x6d\x61\x6b\145\x5f\x73\160\145\x65\x64\137\x72\151\x64\145\x72\137\144\x72\x69\x76\x65\162", $data); goto oGi7s; FgAOh: $rider_id = Token::getCurrentRid(); goto wy5OS; HhWid: return $this->result(0, "\346\267\xbb\345\212\xa0\xe5\xa4\xb1\xe8\264\245\54\40\350\257\267\347\xa8\215\345\220\216\xe9\x87\215\xe8\257\x95");