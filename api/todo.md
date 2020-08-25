# Version 0.5 - Pre-Checklist

- [ ] Add Audit system.
- [ ] Add tags
- [ ] Add Error Handler system
- [ ] Autoload files
- [ ] Redesign AdminCP 
- [ ] Build Moderation panel
- [ ] Rework the FileSystem 
- [ ] Rework the DatabaseSystem 
- [ ] Create a routing engine & make sure it's secure
- [ ] Extend database class (generate tables based on classes)


# Version 0.4 - Checklist

- [x] Tokens relationship with database
- [x] Rework the sessions and how they behave.
- [x] Users must be refreshed, must add Restrictions, Roles and Access Levels
- [x] Finish the transfer from oldAdmin to API 
- [x] Rebrand it: Zephyrus
- [x] Add categories
- [x] Add pagination
- [x] Finish posts page
- [ ] Add `search`
- [x] Add `edit/delete` posts
- [x] Complete the admin panel (Fields for User & Posts, Categories tab)
- [ ] Finish the linking & release

# Frontend raw content
Access this link: [Click me](https://github.com/zaBogdan/Zephyrus/tree/6743cb4790e57db68d66f722f739b6ab32b00579)
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




