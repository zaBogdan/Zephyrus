# Version 0.4 - Checklist

- [x] Tokens relationship with database
- [x] Rework the sessions and how they behave.
- [ ] Users must be refreshed, must add Restrictions, Roles and Access Levels
- [ ] Implement the FileSystem 
- [ ] Routing/Rendering engine implementation must be redone
- [ ] Autoload files
- [ ] Finish the transfer from oldAdmin to API 

> **Note**: Everything that's under this is not implemented yet. To be done.

# List of permissions (this will be updated with features)

### Moderation
- warnUser
- restrictUser
- modifyForeignUser
- modifyForeignContent
- modifyForeignProfile
- modifyForeignComments
- hidePosts
- hideProfile
- editPosts

### Administrative
- accessAdmin
- assignRole
- assignAdministrativeRole
- revokeForeignToken


### UserContent
- uploadFiles
- unlimitedSize
- readPosts
- createPosts
- createGroups
- addComments
- removeComments
- noValidationNeeded

# Roles

### Founder
- * (which means everything)

### Administrator
- * \ (assignAdministrativeRole)

### Moderator
- accessAdmin
- * from Moderation

### Trusted User (>100 followers)
- * from UserContent \ (unlimitedSize)

### Reader 
- * from UserContent \ (unlimitedSize, noValidationNeeded)

### Guest (non logged user)
- readPosts

# Database structure

- Permissions & their fancy description (not really needed, but it can be nice to UI when creating roles) `id, permission, description`
- Roles `id, role, descendantID(only 1 number), premissionsID(array of numbers), description`
- An user can have on it's `data` section alongside `role` a category named `specialPermissions` which can grant him and only him some non group specific perms (like Reader 1 can have accessAdmin perm, but all other Readers don't have this permission).



