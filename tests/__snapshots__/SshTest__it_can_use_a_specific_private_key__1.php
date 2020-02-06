<?php return 'ssh -i /home/user/.ssh/id_rsa -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
