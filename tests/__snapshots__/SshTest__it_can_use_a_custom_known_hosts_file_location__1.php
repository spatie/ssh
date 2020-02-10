<?php return 'ssh -o UserKnownHostsFile=/tmp/custom user@github.com \'bash -se\' << \\EOF-SPATIE-SSH
whoami
EOF-SPATIE-SSH';
