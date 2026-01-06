using MauritiusMap.Data;
using Microsoft.EntityFrameworkCore;

var builder = WebApplication.CreateBuilder(args);

// 1. Add services to the container.
builder.Services.AddControllers();
builder.Services.AddEndpointsApiExplorer(); // <--- ADD THIS
builder.Services.AddSwaggerGen();
// 2. REGISTER DATABASE CONNECTION
var connectionString = builder.Configuration.GetConnectionString("DefaultConnection");
builder.Services.AddDbContext<TreasureMapContext>(options =>
    options.UseSqlServer(connectionString));

var app = builder.Build();
app.UseSwagger();                           // <--- ADD THIS
app.UseSwaggerUI();
// 3. Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.UseDeveloperExceptionPage();
}

app.UseHttpsRedirection();

// 4. ENABLE STATIC FILES (Critical for serving .html and .css)
app.UseStaticFiles();

app.UseAuthorization();
app.MapControllers();

app.Run();