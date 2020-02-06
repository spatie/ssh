<?php return 'ssh -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -p 123 user@example.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
