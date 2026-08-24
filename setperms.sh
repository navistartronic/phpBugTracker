#!/bin/bash
 
# Script file to setup perms, ownership and SELinux contexts necessary 
# for phpBugTracker usage. Run this before running install.php from the 
# browser for the initial installation.

# --- BEGIN SCRIPT CONFIGURATION ---

# Set these script vars for your installation:
INSTALL_DIR="/var/www/html"
WEBSVR_OWNER="apache"
WEBSVR_GROUP="nobody"

# --- END SCRIPT CONFIGURATION ---

# check for install dir
if [ ! -d $INSTALL_DIR ]; then
   echo "${0}: INSTALL_DIR = $INSTALL_DIR does not exist"
   exit 1
fi

# These are the only writable directories and files required
WRITABLE_DIRS="${INSTALL_DIR}/attachments ${INSTALL_DIR}/jpgimages ${INSTALL_DIR}/db"
WRITABLE_FILES="${INSTALL_DIR}/setperms.sh ${INSTALL_DIR}/db/phpbugtracker-demo.sqlite3"

# check for existance of writable directories
missing=0
for d in $WRITABLE_DIRS; do
    if [ ! -d ${d} ]; then
       echo "${0}: missing directory ${d}"
       missing=`expr $missing + 1`
    fi
done
if [ $missing -ne 0 ]; then
   echo "${0}: missing directories, ${missing} error(s) in install."
   exit 1
fi

# check for existance of writable files
missing=0
for d in $WRITABLE_FILES; do
    if [ ! -f ${d} ]; then
       echo "${0}: missing file ${d}"
       missing=`expr $missing + 1`
    fi
done
if [ $missing -ne 0 ]; then
   echo "${0}: missing files, ${missing} error(s) in install."
   exit 2
fi

# Good to go

# Set perms:
# read-only: 
find $INSTALL_DIR -type f -exec chmod 400 {} \;
find $INSTALL_DIR -type d -exec chmod 500 {} \;

# writeables:
chmod 700 $WRITABLE_DIRS
chmod 600 $WRITABLE_FILES

# Set ownership:
chown -R ${WEBSVR_OWNER}:${WEBSVR_GROUP} $INSTALL_DIR

# SELinux when applicable:
# Check which Linux Security Module is in effect
LSM_SELINUX=`[ -f /sys/kernel/security/lsm ] && cat /sys/kernel/security/lsm | grep -ci selinux || echo 0`
if [ $LSM_SELINUX -gt 0 ]; then
   # set selinux contexts to allow webserver write access to the writeable directories

   # To delete these custom contexts:
   if [ 0 -ge 1 ]; then
      echo "deleting contexts ..."
      semanage fcontext -d "${INSTALL_DIR}/attachments(/.*)?"
      semanage fcontext -d "${INSTALL_DIR}/jpgimages(/.*)?"
      semanage fcontext -d "${INSTALL_DIR}/db(/.*)?"
      restorecon -R ${INSTALL_DIR}/attachments
      restorecon -R ${INSTALL_DIR}/jpgimages
      restorecon -R ${INSTALL_DIR}/db
   fi

   # Set the contexts to allow the webserver writes on these directories:
   # The semange(8) mod will be permanently stored in:
   #    /etc/selinux/targeted/contexts/files/file_contexts.local
   # so that restorecon -R /var/www/html will include these additional contexts
   echo "applying SELinux contexts:"

   for d in $WRITABLE_DIRS; do
      echo "context before: `ls -ldZ $d`"
      set -x
      semanage fcontext -a -t httpd_sys_rw_content_t "${d}(/.*)?"
      restorecon -R $d
      set +x
      echo "context after: `ls -ldZ $d`"
      echo ""
   done
fi

echo "setup done."

exit 0
