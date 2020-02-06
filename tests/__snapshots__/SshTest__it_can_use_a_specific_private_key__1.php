<?php return 'ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -i /home/user/.ssh/id_rsa user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
