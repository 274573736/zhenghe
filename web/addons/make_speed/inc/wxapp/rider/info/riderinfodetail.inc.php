<?php
 goto gxa4i; rYHX0: $train = pdo_get("\155\x61\x6b\x65\137\x73\160\x65\x65\144\137\164\x72\x61\151\156\x5f\x72\x69\144\145\x72", array("\162\151\x64\x65\x72\137\x69\144" => $GLOBALS["\103\x55\x52\x52\x45\116\x54\x5f\122\x49\104\x45\122"]), array("\x74\x72\x61\x69\156\137\x69\144")); goto I33s4; G4VDe: $info["\164\162\x61\x69\156"] = "\x31\x31\61"; goto rYHX0; ODFkV: $info["\164\x72\x61\x69\x6e"] = !empty($train["\156\141\x6d\145"]) ? $train["\x6e\x61\x6d\x65"] : ''; goto CeM3u; SjwH1: UCIFg: goto ODFkV; l6ZmS: $train = pdo_get("\x6d\141\x6b\145\x5f\x73\x70\x65\x65\x64\x5f\164\162\141\151\156\x5f\x70\157\x69\x6e\164", array("\x69\x64" => $train["\x74\162\141\151\156\137\x69\144"]), array("\x6e\141\x6d\145")); goto SjwH1; gxa4i: global $_W, $_GPC; goto BaT9r; BaT9r: $info = pdo_get("\x6d\x61\x6b\x65\x5f\163\160\145\145\144\x5f\162\x69\x64\145\x72", array("\151\x64" => $GLOBALS["\103\x55\x52\x52\x45\x4e\x54\137\x52\x49\104\x45\x52"]), array("\x68\145\151\147\x68\x74", "\167\145\151\x67\x68\x74", "\141\147\x65", "\145\x64\x75\x63\141\164\151\157\x6e", "\157\x63\x63\x75\160", "\x61\x64\x64\162\145\x73\x73", "\156\145\162\x76\x6f\x75\x73\x5f\x70\x65\162\163\x6f\x6e", "\x6e\x65\x72\166\157\x75\x73\137\x70\x68\157\x6e\145")); goto G4VDe; I33s4: if (empty($train["\164\x72\x61\x69\156\x5f\x69\144"])) { goto UCIFg; } goto l6ZmS; CeM3u: return $this->result(0, '', $info);