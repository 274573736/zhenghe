<?php
 goto X0kvh; X0kvh: defined("\x49\116\x5f\111\101") or exit("\x41\143\x63\x65\163\163\x20\104\x65\x6e\x69\x65\144"); goto vqY6L; iYWlP: if (is_business_host($id)) { goto BH7Iu; } goto s23zZ; G3Rpp: VoWQh: goto qrzzp; xfnCo: return $this->result(0, "\xe5\272\227\345\x91\230" . $data["\x75\163\x65\162\x5f\x69\x64"] . "\xe5\267\262\xe5\255\x98\xe5\x9c\xa8"); goto TOHjX; TOHjX: rABJR: goto OphBI; nE0vv: if (empty($result)) { goto rABJR; } goto xfnCo; tHkKe: return $this->result(0, "\346\267\xbb\xe5\x8a\240\xe5\244\261\350\264\245\357\xbc\201\xe8\257\267\xe7\250\x8d\345\220\216\xe9\207\215\xe8\257\225"); goto G3Rpp; PxPxy: $id = !empty($_GPC["\x69\x64"]) ? intval($_GPC["\151\x64"]) : 0; goto iYWlP; GEEYe: $data["\141\x64\144\137\x74\x69\155\145"] = time(); goto s1kEI; YGQDn: $data["\x73\145\170"] = !empty($_GPC["\x73\x65\x78"]) ? trim($_GPC["\163\x65\170"]) : ''; goto Ya5S8; XVvLK: $data["\165\x73\x65\162\137\151\x64"] = !empty($_GPC["\165\x69\x64"]) ? intval($_GPC["\165\151\x64"]) : 0; goto fDp2c; OphBI: $add = pdo_insert("\155\141\153\x65\x5f\x73\x70\145\145\144\x5f\142\165\x73\151\x6e\145\163\163\137\x75\163\145\162", $data); goto BkbD8; Ya5S8: $data["\x6d\x6f\x62\151\154\x65"] = !empty($_GPC["\x70\x68\157\x6e\145"]) ? trim($_GPC["\x70\x68\x6f\x6e\x65"]) : ''; goto dsX6E; BkbD8: if (!empty($add)) { goto VoWQh; } goto tHkKe; s23zZ: return $this->result(0, "\346\xb7\273\345\212\xa0\345\244\261\xe8\xb4\xa5\54\x20\xe6\x82\xa8\xe5\xbd\x93\345\x89\x8d\350\xb4\xa6\xe5\x8f\xb7\344\xb8\215\xe6\x98\257\xe4\xb8\273\xe7\xae\xa1\347\220\x86"); goto DNwZs; dsX6E: $data["\150\157\x6d\145\137\x61\144\x64\162\x65\x73\x73"] = !empty($_GPC["\x61\144\x64\162\145\163\163"]) ? trim($_GPC["\141\144\144\162\145\x73\163"]) : ''; goto XVvLK; vqY6L: global $_W, $_GPC; goto PxPxy; nQnX8: $data["\x75\x73\145\162\156\x61\155\x65"] = !empty($_GPC["\x6e\x61\155\x65"]) ? trim($_GPC["\156\141\x6d\145"]) : ''; goto YGQDn; fDp2c: $data["\x62\165\163\151\156\x65\x73\x73\137\x69\144"] = $id; goto GEEYe; s1kEI: $result = pdo_get("\x6d\x61\x6b\145\137\x73\160\145\145\x64\x5f\x62\x75\163\x69\156\x65\163\x73\137\x75\x73\x65\x72", array("\x75\163\x65\162\137\151\x64" => $data["\165\x73\x65\x72\137\x69\x64"], "\x62\x75\x73\x69\x6e\x65\163\163\137\x69\144" => $id), array("\151\x64")); goto nE0vv; DNwZs: BH7Iu: goto nQnX8; qrzzp: return $this->result(0, '', array(1));