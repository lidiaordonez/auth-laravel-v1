/**
 * This file is cloned / force-published from the "auth-laravel-v1" composer package.
 *    WARNING: Local modifications will be overwritten when the package is updated.
 *             See https://github.com/faithfm/auth-laravel-v1 for more details.
 */

// DEPENDENCY NOTE: We are expecting LaravelAppGlobals.users.permissions from our Laravel app, passed in via our Blade template.

// return true if user has the specified permission - ie: "use-app"
export function laravelUserCan(permissionToCheck) {
    return LaravelAppGlobals.user.permissions.some(p => p.permission===permissionToCheck);
}

// return any restrictions associated with the specified permission
export function laravelUserRestrictions(permissionToCheck) {
    const perm = LaravelAppGlobals.user.permissions.find(p => p.permission===permissionToCheck);
    if (perm === undefined)   return { status:"NOT PERMITTED" }
    if (!perm.restrictions )  return { status:"ALL PERMITTED" }
    try { return  { status:"SOME PERMITTED", ...perm.restrictions } }
    catch { return { status:"NOT PERMITTED", error:"ERROR DECODING RESTRICTIONS" } }   // note: now that JSON encoding is being handled by array-casting in the Model back-end, this error checking is less important.  (JSON errors now get converted by backend to NULLs without complaint)
}
