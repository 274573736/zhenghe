<?php
 goto VbywM; Ptg5W: $limit = !empty($_GPC["\154\151\155\151\164"]) ? intval($_GPC["\154\x69\155\x69\x74"]) : 0; goto VijVp; yMt21: $where["\x6d\x2e\141\154\154"] = 1; goto cemZg; RUZv4: $page = !empty($_GPC["\160\x61\147\x65"]) ? intval($_GPC["\160\141\147\x65"]) : 0; goto Ptg5W; dUIx4: foreach ($results as $k => $v) { goto UPjcn; Hp4hd: $results[$k]["\141\144\144\x5f\x74\151\155\145"] = date("\131\x2d\x6d\x2d\144\x20\110\x3a\x69", $v["\x61\x64\x64\137\x74\151\x6d\x65"]); goto bSeho; zJ9uh: dMwnM: goto Hp4hd; bSeho: S_Njb: goto KQ6kr; UPjcn: if (empty($v["\156\151\143\x6b\x5f\x6e\141\155\x65"])) { goto dMwnM; } goto GpwPh; GpwPh: $results[$k]["\x63\x6f\156\x74\145\156\x74"] = "\x5b\xe9\xaa\x91\346\x89\213\x3a" . $v["\x6e\151\143\153\137\156\141\x6d\145"] . "\135" . $v["\143\157\x6e\164\x65\156\164"]; goto zJ9uh; KQ6kr: } goto a4jqw; AY6NB: gDxZs: goto dUIx4; VbywM: global $_W, $_GPC; goto FswMc; eEhao: goto EMnTt; goto Ayrsh; OsW35: $where["\155\56\162\x69\x64\x65\162\x5f\x69\144"] = intval($GLOBALS["\x43\x55\x52\x52\x45\116\x54\x5f\122\x49\x44\105\122"]); goto LuGf7; WjwE1: return $this->result(0, ''); goto AY6NB; Ayrsh: We2fF: goto rsr1_; OjOVa: goto EKVre; goto dj4UW; VijVp: $page > 0 || ($page = 1); goto SyICt; DaQ0m: if (!($type == 2)) { goto BtVju; } goto NtL3g; gvCMo: BtVju: goto eEhao; s3tXw: if (!empty($results)) { goto gDxZs; } goto WjwE1; SyICt: $limit > 0 || ($limit = 10); goto wSB1F; FswMc: $type = !empty($_GPC["\164\171\160\x65"]) ? intval($_GPC["\x74\171\160\145"]) : 0; goto RUZv4; oz0y8: EMnTt: goto OjOVa; OpTOD: if ($type == 1) { goto We2fF; } goto DaQ0m; LuGf7: EKVre: goto mpuxc; rsr1_: $where["\x6d\x2e\x74\171\160\145"] = 0; goto yMt21; MTnPJ: $where["\155\56\162\151\x64\x65\162\137\x69\x64\40\x21\x3d"] = intval($GLOBALS["\x43\x55\122\122\x45\x4e\124\x5f\x52\x49\x44\x45\x52"]); goto gvCMo; rLugo: if (empty($type)) { goto Ld3DE; } goto OpTOD; dj4UW: Ld3DE: goto OsW35; NtL3g: $where["\155\x2e\x74\x79\160\145"] = 1; goto V9PsK; mpuxc: $results = load()->object("\161\x75\145\162\x79")->from("\155\141\x6b\x65\137\x73\x70\145\x65\x64\137\x72\151\144\145\x72\x5f\x6d\145\163\163\x61\x67\x65", "\155")->leftjoin("\x6d\x61\x6b\145\137\x73\x70\145\145\144\137\x72\151\x64\145\x72", "\162")->on(array("\155\56\162\x69\144\x65\162\137\x69\144" => "\x72\56\x69\x64"))->where($where)->select("\155\56\x69\144", "\x6d\x2e\x74\x69\164\x6c\145", "\155\x2e\x63\x6f\156\164\x65\156\x74", "\155\56\141\144\144\137\x74\x69\x6d\145", "\x72\x2e\x6e\x69\143\153\137\x6e\x61\x6d\x65")->orderby("\151\144\x20\144\x65\163\143")->page($page, $limit)->getall(); goto s3tXw; a4jqw: x9wir: goto z5f_C; wSB1F: $where = array("\155\56\165\x6e\151\x61\143\x69\x64" => $GLOBALS["\x75\x6e\x69\x61\x63\151\x64"]); goto rLugo; V9PsK: $where["\x6d\x2e\x61\x6c\154"] = 1; goto MTnPJ; cemZg: $where["\x6d\x2e\162\151\x64\x65\x72\x5f\151\x64\40\x21\75"] = intval($GLOBALS["\x43\x55\122\122\105\116\124\x5f\x52\x49\x44\105\x52"]); goto oz0y8; z5f_C: return $this->result(0, '', $results);