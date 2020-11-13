#! /bin/bash
for machine in $(VBoxManage list vms|cut -d" " -f 1); do
  echo "$machine"
done
