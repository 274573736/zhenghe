<?php
 use Validate\app\Login; use Server\app\UserToken; goto nZntu; EkycM: $mobile = $this->request->param("\155\157\142\x69\154\x65"); goto TzoFv; TzoFv: $code = $this->request->param("\x63\157\x64\x65"); goto ErPqA; nZntu: (new Login())->goCheck(); goto EkycM; XuZhl: $token = (new UserToken())->smsLogin($mobile, $code, $client); goto Bhh8b; ErPqA: $client = $this->request->param("\141\160\x70\137\x63\x6c\x69\145\x6e\x74\137\151\144"); goto XuZhl; Bhh8b: return msg("\x73\x75\143\143\x65\163\x73", ["\164\157\153\145\x6e" => $token]);