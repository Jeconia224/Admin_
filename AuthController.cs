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

        // 🔹 TEST ENDPOINT (PROVES DATABASE CONNECTION)
        // URL: GET /api/auth/test-db
        [HttpGet("test-db")]
        public IActionResult TestDatabase()
        {
            var users = _context.Logins.ToList();
            return Ok(users);
        }

        // 🔹 LOGIN ENDPOINT
        // URL: POST /api/auth/login
        [HttpPost("login")]
        public IActionResult Login([FromBody] LoginRequest request)
        {
            // Safety check
            if (request == null || string.IsNullOrEmpty(request.Email) || string.IsNullOrEmpty(request.Password))
            {
                return BadRequest(new { message = "Email and password are required" });
            }

            // 1. Find user by email and password
            var user = _context.Logins.FirstOrDefault(u =>
               u.mail.ToLower() == request.Email.ToLower() &&
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
            return Ok(new
            {
                message = "Login Successful",
                username = user.username,
                role = user.role
            });
        }
    }
}
