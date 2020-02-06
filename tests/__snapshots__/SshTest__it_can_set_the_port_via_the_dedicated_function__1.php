<?php return 'ssh -p 123 -o UserKnownHostsFile=/tmp/test user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
