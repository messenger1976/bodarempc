# Menu Image Upload Implementation

## Overview
This document describes the implementation of image upload functionality for the Menu Management system at `/dashboard/menu` using Dropzone.js plugin.

## Changes Made

### 1. Database Schema Update
**Action Required:** Add the following column to the `menu` table in your database:

```sql
ALTER TABLE menu ADD COLUMN menuimage VARCHAR(255) DEFAULT NULL AFTER menulink;
```

This column stores the filename of the uploaded menu image.

### 2. Controller Updates
**File:** `application/modules/dashboard/controllers/Menu.php`

#### Modified Methods:

#### `add()` Method
- Added image upload handling via Dropzone.js
- Validates file type (jpg, png, jpeg, gif)
- Generates unique filename using timestamp and random numbers
- Stores filename in `menuimage` column
- Saves image to: `images/website/menu/`
- Returns JSON response with success or error message

#### `update()` Method
- Added image upload handling for menu editing
- Deletes old image when new one is uploaded
- Maintains backward compatibility if no image is uploaded
- Returns JSON response with success or error message

### 3. View Updates

#### `application/modules/dashboard/views/Menu/menu.php` (Add Modal)
**Changes:**
- Added Dropzone.js container with ID `menuAddDropzone`
- Added hidden input field `menuimage` to store uploaded filename
- Integrated Dropzone.js CSS and JS libraries
- Added JavaScript initialization for Add Menu Dropzone
- Implemented AJAX form submission with file handling

**Features:**
- Drag-and-drop image upload
- Click to select image
- Max file size: 5 MB
- Accepted formats: jpg, png, jpeg, gif
- Automatic file validation
- Real-time file preview

#### `application/modules/dashboard/views/Menu/edit.php` (Edit Form)
**Changes:**
- Added Dropzone.js container with ID `menuEditDropzone`
- Added image preview for existing menu image
- Added hidden input field `menuimage` to store uploaded filename
- Integrated Dropzone.js CSS and JS libraries
- Added JavaScript initialization for Edit Menu Dropzone
- Implemented AJAX form submission with file handling

**Features:**
- Displays current image (if exists)
- Drag-and-drop image replacement
- Click to select new image
- Max file size: 5 MB
- Accepted formats: jpg, png, jpeg, gif
- Old image deletion on update

### 4. Folder Structure
**Created:** `images/website/menu/`

This folder stores all uploaded menu images with the following structure:
```
images/
└── website/
    └── menu/
        ├── 20260119_143022_5678_1234.jpg
        ├── 20260119_143045_1234_5678.png
        └── ... (more images)
```

## Technical Details

### File Naming Convention
Uploaded files follow this pattern:
```
{YYYYMMDD}_{HHMMSS}_{RAND}_{RAND}{RAND}.{ext}
```

Example: `20260119_143022_5678_1234.jpg`

This ensures unique filenames and prevents conflicts.

### Image Upload Configuration
- **Library Used:** Dropzone.js
- **Upload Path:** `images/website/menu/`
- **Allowed Types:** jpg, png, jpeg, gif
- **Max File Size:** 5 MB
- **Allowed Files per Form:** 1

### Database Storage
The `menuimage` column stores only the filename (not the full path):
```php
// Example record
{
    menuid: 5,
    menuname: "Products",
    menuimage: "20260119_143022_5678_1234.jpg"
}
```

### Image Display in Frontend
To display the menu image in your frontend, use:
```php
<?php if (!empty($menu->menuimage)): ?>
    <img src="<?php echo base_url(); ?>images/website/menu/<?php echo $menu->menuimage; ?>" alt="<?php echo $menu->menuname; ?>">
<?php endif; ?>
```

## AJAX Form Handling

### Add Menu Form
```javascript
// Triggered when "Add Menu" button is clicked
// Collects form data with dropzone file
// Sends to: dashboard/menu/add
// Returns: JSON success/error response
```

### Edit Menu Form
```javascript
// Triggered when "Update Menu" button is clicked
// Collects form data with optional dropzone file
// Sends to: dashboard/menu/update
// Returns: JSON success/error response
// Deletes old image if new one is uploaded
```

## API Endpoints

### Add Menu with Image
**URL:** `POST /dashboard/menu/add`

**Form Data:**
```
menuname: "Menu Name" *required
menuparent: "parent_menu_id"
menupage: "page_slug"
menulink: "http://example.com"
menuimage: <File Object>
```

**Response:**
```json
{
    "success": "Successfully Inserted"
}
```

Or error response:
```json
{
    "errorFormValidation": "The following fields are required: Menu Name"
}
```

### Update Menu with Image
**URL:** `POST /dashboard/menu/update`

**Form Data:**
```
menuid: "5" *required
menuname: "Menu Name" *required
menuparent: "parent_menu_id"
menupage: "page_slug"
menulink: "http://example.com"
menuimage: <File Object> (optional)
```

**Response:**
```json
{
    "success": "Successfully Updated"
}
```

## Error Handling

### Image Upload Errors
If image upload fails, the following error responses are returned:

1. **Invalid File Type:**
   ```json
   {
       "menuimage_error": "The filetype you are attempting to upload is not allowed."
   }
   ```

2. **File Too Large:**
   ```json
   {
       "menuimage_error": "The file you are attempting to upload is larger than the permitted size."
   }
   ```

3. **Other Upload Errors:**
   ```json
   {
       "menuimage_error": "Error message from CodeIgniter Upload library"
   }
   ```

### Form Validation Errors
```json
{
    "errorFormValidation": "The following fields are required: Menu Name"
}
```

### Database Errors
```json
{
    "notsuccess": "Opps! Something Wrong"
}
```

## Dropzone.js Configuration

### Add Menu Dropzone
```javascript
var menuAddDropzone = new Dropzone("#menuAddDropzone", {
    url: "<?php echo base_url(); ?>dashboard/menu/add",
    maxFilesize: 5, // 5 MB
    acceptedFiles: "image/*",
    uploadMultiple: false,
    maxFiles: 1,
    paramName: "menuimage",
    autoQueue: false, // Manual upload with form submission
    addRemoveLinks: true
});
```

### Edit Menu Dropzone
```javascript
var menuEditDropzone = new Dropzone("#menuEditDropzone", {
    url: "<?php echo base_url(); ?>dashboard/menu/update",
    maxFilesize: 5, // 5 MB
    acceptedFiles: "image/*",
    uploadMultiple: false,
    maxFiles: 1,
    paramName: "menuimage",
    autoQueue: false, // Manual upload with form submission
    addRemoveLinks: true
});
```

## Usage Flow

### Adding a Menu with Image
1. Click "Add Menu" button
2. Fill in Menu Name (required)
3. Optionally select Parent Menu
4. Optionally select Menu Page
5. Optionally enter Menu Link
6. **NEW:** Drag-and-drop or click to upload menu image
7. Click "Add Menu" button to submit
8. Image is uploaded and filename saved to database
9. Page reloads with new menu displayed

### Editing a Menu with New Image
1. Click "Edit" button next to a menu item
2. Current menu image is displayed (if exists)
3. Modify fields as needed
4. **NEW:** Optionally upload a new image to replace current one
5. Click "Update Menu" to submit
6. If new image uploaded:
   - Old image file is deleted from `images/website/menu/`
   - New image is saved
   - Database updated with new filename
7. Page redirects to menu list

## Compatibility

### Browser Support
- Chrome/Edge (Latest)
- Firefox (Latest)
- Safari (Latest)
- IE 10+ (with polyfills)

### Framework
- CodeIgniter 3.x
- Bootstrap 3.x
- jQuery
- Dropzone.js v5.x

## Files Modified

1. `application/modules/dashboard/controllers/Menu.php`
   - `add()` method - Added image upload logic
   - `update()` method - Added image upload logic with old image deletion

2. `application/modules/dashboard/views/Menu/menu.php`
   - Added Dropzone.js container for Add Modal
   - Added Dropzone.js scripts and initialization
   - Added AJAX form submission handling

3. `application/modules/dashboard/views/Menu/edit.php`
   - Added Dropzone.js container for Edit Form
   - Added current image preview
   - Added Dropzone.js scripts and initialization
   - Added AJAX form submission handling

## Files Created

1. `images/website/menu/` (Directory)
   - Stores all uploaded menu images

## Future Enhancements

1. **Image Processing:**
   - Automatic image resizing/cropping
   - Thumbnail generation
   - Image optimization

2. **Additional Features:**
   - Image gallery for menu
   - Multiple images per menu
   - Image ordering/sorting
   - Image alt text management

3. **Security:**
   - Enhanced file validation
   - Image malware scanning
   - Watermarking

## Troubleshooting

### Images Not Uploading
1. Check `images/website/menu/` folder permissions (should be 755 or writable)
2. Verify file size is under 5 MB
3. Ensure file format is supported (jpg, png, jpeg, gif)
4. Check browser console for AJAX errors

### Old Images Not Deleting
1. Verify folder permissions on `images/website/menu/`
2. Check if file physically exists before update
3. Ensure proper file path in update method

### Dropzone Not Appearing
1. Verify Dropzone.js library is properly linked in footer
2. Check browser console for JavaScript errors
3. Ensure `#menuAddDropzone` or `#menuEditDropzone` IDs exist

### Form Not Submitting
1. Check browser console for AJAX errors
2. Verify jQuery is loaded before Dropzone scripts
3. Check network tab in developer tools for POST requests
4. Verify correct endpoint URL in AJAX call

## Support

For issues or questions regarding this implementation, contact the development team or refer to:
- Dropzone.js Documentation: https://www.dropzonejs.com/
- CodeIgniter Upload Library: https://codeigniter.com/userguide3/libraries/file_uploading.html
