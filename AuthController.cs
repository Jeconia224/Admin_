using Microsoft.AspNetCore.Mvc;
using MauritiusMap.Data;
using MauritiusMap.Models;
using System.Linq;

namespace MauritiusMap.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class AuthController : ControllerBase
    {
        private readonly TreasureMapContext _context;

        public AuthController(TreasureMapContext context)
        {
            _context = context;
        }

        // DTO to capture user input safely
        public class LoginRequest
        {
            public string Email { get; set; }
            public string Password { get; set; }
        }

        [HttpPost("login")]
        public IActionResult Login([FromBody] LoginRequest request)
        {
            // 1. Find user by email and password
            var user = _context.Logins.FirstOrDefault(u =>
                u.mail == request.Email &&
                u.password == request.Password);

            if (user == null)
            {
                return Unauthorized(new { message = "Invalid Credentials" });
            }

            // 2. Check if role is Admin
            if (user.role.ToLower() != "admin")
            {
                return Unauthorized(new { message = "Access Denied: Admins Only" });
            }

            // 3. Success
            return Ok(new { message = "Login Successful", username = user.username });
        }
    }
}