<?php
 goto UJCsJ; UJCsJ: global $_W, $_GPC; goto kyrrC; kyrrC: $data = array("\156\151\143\153\x5f\x6e\x61\x6d\145" => !empty($_GPC["\156\151\143\153\x4e\141\x6d\145"]) ? $_GPC["\x6e\x69\143\x6b\x4e\x61\x6d\x65"] : $_W["\146\x61\156\x73"]["\x6e\151\143\153\x6e\141\x6d\x65"], "\x61\166\x61\164\x61\162" => !empty($_GPC["\x61\x76\141\x74\141\x72\125\x72\154"]) ? $_GPC["\x61\x76\141\164\x61\x72\125\x72\x6c"] : $_W["\x66\141\156\x73"]["\141\x76\x61\x74\x61\x72"], "\x73\145\170" => !empty($_GPC["\x73\145\x78"]) ? $_GPC["\163\x65\170"] : $_W["\146\141\x6e\x73"]["\x67\x65\156\144\x65\x72"]); goto hm46Q; usDou: Kjnl9: goto KnJtB; GcXF_: load()->func("\154\x6f\147\147\x69\x6e\x67"); goto QZ2ff; PfNFw: if (!empty($up)) { goto Kjnl9; } goto GcXF_; QZ2ff: logging_run(date("\131\x2d\x6d\x2d\144\40\110\72\151") . "\x5b\x52\x69\144\x65\x72\40\x75\160\x64\141\164\145\x69\156\146\x6f\x5d\40\x45\162\162\157\x72\x3a\x20" . json_encode($data) . "\x2d\x2d\55\x2d\x6f\160\x65\156\x69\144\72" . $_W["\157\160\145\x6e\x69\144"], "\x74\162\x61\x63\145", "\x6d\x61\x6b\145\163\x70\x65\x65\x64\154\x6f\x67"); goto usDou; hm46Q: $up = pdo_update("\x6d\141\x6b\145\x5f\163\x70\x65\145\x64\137\162\151\144\145\162", $data, array("\x75\156\151\141\x63\x69\144" => $GLOBALS["\x75\156\151\141\143\x69\x64"], "\x6f\160\145\156\x5f\x69\x64" => $_W["\x6f\x70\x65\x6e\x69\x64"])); goto PfNFw; KnJtB: return $this->result(0, '');