# Version 0.5 - Pre-Checklist

- [ ] Add Audit system.
- [ ] Add Error Handler system
- [ ] Autoload files
- [ ] Redesign AdminCP 
- [ ] Build Moderation panel
- [ ] Rework the FileSystem 
- [ ] Create a routing engine & make sure it's secure
- [ ] Extend database class (generate tables based on classes)


# Version 0.4 - Checklist

- [x] Tokens relationship with database
- [x] Rework the sessions and how they behave.
- [x] Users must be refreshed, must add Restrictions, Roles and Access Levels
- [x] Finish the transfer from oldAdmin to API 
- [x] Rebrand it: Zephyrus

# Frontend raw content
Access this link: [Click me](https://github.com/zaBogdan/Zephyrus/tree/6743cb4790e57db68d66f722f739b6ab32b00579)
> **Note**: Everything that's under this is not implemented yet. To be done.

# Phase: Users must be refreshed 

Done now:
 - Users have now Roles (explained down)
 - Permissions & Roles can be added only by code (UI will be in 0.5)
 - Confirmation email phase 1 is now done
 - Get all the checks done for confirmation email, forgot password 
 - Make sure that everything is secured (using permissions).

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
- deleteExistingUser
- readTokens


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




