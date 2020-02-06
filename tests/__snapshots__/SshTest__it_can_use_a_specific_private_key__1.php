<?php return 'ssh -i /home/user/.ssh/id_rsa -o UserKnownHostsFile=/tmp/test user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
