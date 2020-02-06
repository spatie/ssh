<?php return 'ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
cd /var/log
EOF-SPATIE-SSH';
