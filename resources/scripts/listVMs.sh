#! /bin/bash
for machine in $(VBoxManage list runningvms|cut -d" " -f 1); do
  echo "$machine"
done
