<?php return 'ssh -p 123 -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
